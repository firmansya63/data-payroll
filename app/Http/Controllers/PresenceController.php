<?php
namespace App\Http\Controllers;
use App\Models\Presence;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\BarcodeGenerator;

class PresenceController extends Controller
{
    public function index(Request $r){
        return redirect()->route('presences.calendar', $r->only('bulan','tahun','employee_id'));
    }

    public function calendar(Request $r){
        $bulan = (int)($r->bulan ?? now()->month);
        $tahun = (int)($r->tahun ?? now()->year);
        if($bulan < 1) $bulan = 1; if($bulan > 12) $bulan = 12;
        if($tahun < 2020) $tahun = 2020; if($tahun > 2035) $tahun = 2035;
        $employeeId = $r->employee_id;

        $employees = Employee::where('is_active',true)->orderBy('nama')->get();
        $selectedEmployee = $employeeId ? Employee::where('is_active',true)->find($employeeId) : null;

        $first = Carbon::create($tahun, $bulan, 1);
        $daysInMonth = $first->daysInMonth;
        $firstDayIso = $first->dayOfWeekIso; // 1 Mon .. 7 Sun
        $offset = $firstDayIso - 1;
        $prev = $first->copy()->subMonth();
        $next = $first->copy()->addMonth();

        $grouped = collect();
        $rekap = null;
        $presencesMonth = collect();
        $rekapSemua = null;
        if($selectedEmployee){
            $presencesMonth = Presence::where('employee_id',$selectedEmployee->id)
                ->whereMonth('tanggal',$bulan)->whereYear('tanggal',$tahun)->get();
            $grouped = $presencesMonth->keyBy(fn($p)=> $p->tanggal->format('Y-m-d'));
            $rekap = [
                'hadir' => $presencesMonth->where('status','hadir')->count(),
                'izin'  => $presencesMonth->where('status','izin')->count(),
                'sakit' => $presencesMonth->where('status','sakit')->count(),
                'alpha' => $presencesMonth->where('status','alpha')->count(),
            ];
            $rekap['total'] = array_sum($rekap);
            $rekap['kosong'] = $daysInMonth - $rekap['total'];
        } else {
            $countsAll = Presence::whereMonth('tanggal',$bulan)->whereYear('tanggal',$tahun)
                ->selectRaw("employee_id, status, COUNT(*) as cnt")
                ->groupBy('employee_id','status')->get()->groupBy('employee_id');
            $rekapSemua = Employee::where('is_active',true)->orderBy('nama')->get()->map(function($e) use($countsAll){
                $g = $countsAll->get($e->id, collect());
                return [
                    'employee' => $e,
                    'hadir' => $g->firstWhere('status','hadir')->cnt ?? 0,
                    'izin'  => $g->firstWhere('status','izin')->cnt ?? 0,
                    'sakit' => $g->firstWhere('status','sakit')->cnt ?? 0,
                    'alpha' => $g->firstWhere('status','alpha')->cnt ?? 0,
                ];
            });
        }

        return view('presences.calendar', compact('bulan','tahun','employees','selectedEmployee','employeeId','first','daysInMonth','firstDayIso','offset','prev','next','grouped','rekap','presencesMonth','rekapSemua'));
    }

    public function create(Request $r){
        $employees = Employee::where('is_active',true)->orderBy('nama')->get();
        $selectedEmployeeId = old('employee_id', $r->query('employee_id'));
        $selectedDate = old('tanggal', $r->query('tanggal', date('Y-m-d')));
        return view('presences.create', compact('employees','selectedEmployeeId','selectedDate'));
    }
    public function store(Request $r){
        $r->validate([
            'employee_id'=>'required|exists:employees,id',
            'tanggal'=>'required|date',
            'status'=>'required|in:hadir,izin,sakit,alpha',
        ]);
        // prevent duplicate
        $exists = Presence::where('employee_id',$r->employee_id)->whereDate('tanggal',$r->tanggal)->exists();
        if($exists) return back()->withErrors(['tanggal'=>'Presensi karyawan di tanggal ini sudah ada'])->withInput();
        Presence::create($r->only('employee_id','tanggal','status'));
        return redirect()->route('presences.calendar', ['bulan'=>Carbon::parse($r->tanggal)->month, 'tahun'=>Carbon::parse($r->tanggal)->year, 'employee_id'=>$r->employee_id])->with('ok','Presensi disimpan');
    }
    // bulk input harian: admin centang hadir
    public function bulk(Request $r){
        $employees = Employee::where('is_active',true)->orderBy('nama')->get();
        $tanggal = $r->query('tanggal', old('tanggal', date('Y-m-d')));
        $existing = [];
        if($tanggal){
            $existing = Presence::whereDate('tanggal',$tanggal)->pluck('status','employee_id')->toArray();
        }
        return view('presences.bulk', compact('employees','tanggal','existing'));
    }
    public function bulkStore(Request $r){
        $r->validate([
            'tanggal'=>'required|date',
            'presences'=>'required|array',
            'presences.*.employee_id'=>'required|exists:employees,id',
            'presences.*.status'=>'required|in:hadir,izin,sakit,alpha',
        ]);
        foreach($r->presences as $p){
            Presence::updateOrCreate(
                ['employee_id'=>$p['employee_id'], 'tanggal'=>$r->tanggal],
                ['status'=>$p['status']]
            );
        }
        $firstEmp = $r->presences[0]['employee_id'] ?? null;
        return redirect()->route('presences.calendar', ['bulan'=>Carbon::parse($r->tanggal)->month, 'tahun'=>Carbon::parse($r->tanggal)->year, 'employee_id'=>$firstEmp])->with('ok','Presensi bulk disimpan untuk '.Carbon::parse($r->tanggal)->translatedFormat('d F Y'));
    }
    // QR Code Scanner Kiosk / Smartphone Standby
    public function scan(Request $r){
        $employees = Employee::where('is_active',true)->orderBy('nama')->get();
        return view('presences.scan', compact('employees'));
    }

    public function scanStore(Request $r){
        $r->validate([
            'code' => 'required|string',
        ]);

        $code = trim($r->code);
        $employee = null;

        if(str_starts_with($code, 'EMP-')) {
            $id = str_replace('EMP-', '', $code);
            $employee = Employee::where('is_active',true)->find($id);
        } else {
            $employee = Employee::where('is_active',true)->where('id', $code)->orWhere('nama', 'like', "%$code%")->first();
        }

        if(!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Karyawan tidak ditemukan atau tidak aktif untuk kode: ' . $code
            ], 404);
        }

        $today = date('Y-m-d');
        $presence = Presence::where('employee_id', $employee->id)->whereDate('tanggal', $today)->first();

        if($presence) {
            return response()->json([
                'success' => true,
                'already' => true,
                'message' => "{$employee->nama} sudah tercatat absen ({$presence->status}) hari ini pada jam " . $presence->created_at->format('H:i') . ' WIB',
                'employee' => $employee,
                'presence' => $presence
            ]);
        }

        $newPresence = Presence::create([
            'employee_id' => $employee->id,
            'tanggal' => $today,
            'status' => 'hadir'
        ]);

        return response()->json([
            'success' => true,
            'already' => false,
            'message' => "Berhasil! {$employee->nama} ({$employee->jabatan}) tercatat HADIR hari ini.",
            'employee' => $employee,
            'presence' => $newPresence,
            'time' => now()->format('H:i:s')
        ]);
    }

    public function qrcodeCard(Employee $employee) {
        $payload = 'EMP-' . $employee->id;
        $qrImage = BarcodeGenerator::generateSimpleQRCode($payload, 300);
        return view('presences.qrcode-card', compact('employee', 'qrImage', 'payload'));
    }

    public function destroy(Presence $presence){
        $presence->delete();
        return back()->with('ok','Presensi dihapus');
    }
}

