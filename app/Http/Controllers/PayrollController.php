<?php
namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use App\Models\Presence;
use App\Models\ClientAcquisition;
use App\Models\Deduction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PayrollController extends Controller
{
    public function index(Request $r){
        $bulan = $r->bulan ?? now()->month;
        $tahun = $r->tahun ?? now()->year;
        $q = Payroll::with('employee')->where('periode_bulan',$bulan)->where('periode_tahun',$tahun);
        if($s=$r->q) $q->whereHas('employee', fn($qq)=>$qq->where('nama','like',"%$s%"));
        $payrolls = $q->latest()->paginate(20)->withQueryString();
        $employees = Employee::where('is_active',true)->orderBy('nama')->get();
        $summary = [
            'total_gaji'=> (clone $q)->sum('total_terima'),
            'total_pokok'=> (clone $q)->sum('gaji_pokok'),
            'total_bonus'=> (clone $q)->sum('bonus_kehadiran'),
            'total_insentif'=> (clone $q)->sum('total_insentif'),
            'total_lembur'=> (clone $q)->sum('total_lembur'),
            'total_potongan'=> (clone $q)->sum('total_potongan'),
        ];
        return view('payrolls.index', compact('payrolls','bulan','tahun','summary','employees'));
    }

    public function create(Request $r){
        $bulan = $r->bulan ?? now()->month;
        $tahun = $r->tahun ?? now()->year;
        $employees = Employee::where('is_active',true)->orderBy('nama')->get();
        // preview: hitung realtime + prefill lembur dari existing jika sudah pernah digenerate
        $preview = $employees->map(function($e) use($bulan,$tahun){
            $existing = Payroll::where('employee_id',$e->id)->where('periode_bulan',$bulan)->where('periode_tahun',$tahun)->first();
            $oJam = $existing ? (float)$existing->jam_lembur : 0;
            $oNom = $existing ? (float)$existing->total_lembur : 0;
            $oCat = $existing ? $existing->catatan_lembur : null;
            $calc = Payroll::hitung($e->id, $bulan, $tahun, $oJam, $oNom, $oCat);
            $calc['existing'] = $existing;
            $calc['oJam'] = $oJam;
            $calc['oNom'] = $oNom;
            $calc['oCat'] = $oCat;
            $calc['insentif_list'] = ClientAcquisition::where('employee_id',$e->id)->whereMonth('tanggal',$bulan)->whereYear('tanggal',$tahun)->get();
            $calc['potongan_list'] = Deduction::where('employee_id',$e->id)->whereMonth('tanggal',$bulan)->whereYear('tanggal',$tahun)->where('status','belum_dipotong')->get();
            if($existing){
                $linked = Deduction::where('payroll_id',$existing->id)->get();
                if($linked->isNotEmpty()) $calc['potongan_list'] = $linked;
            }
            return $calc;
        });
        return view('payrolls.create', compact('bulan','tahun','employees','preview'));
    }

    public function store(Request $r){
        $r->validate([
            'periode_bulan'=>'required|integer|min:1|max:12',
            'periode_tahun'=>'required|integer|min:2020|max:2035',
            'employee_ids'=>'required|array|min:1',
            'employee_ids.*'=>'exists:employees,id',
            'overtime_jam'=>'nullable|array',
            'overtime_jam.*'=>'nullable|numeric|min:0|max:744',
            'overtime_nominal'=>'nullable|array',
            'overtime_nominal.*'=>'nullable|numeric|min:0|max:999999999',
            'overtime_catatan'=>'nullable|array',
            'overtime_catatan.*'=>'nullable|string|max:255',
        ]);
        $bulan = (int)$r->periode_bulan;
        $tahun = (int)$r->periode_tahun;
        $count=0;
        $reqJam = $r->input('overtime_jam', []);
        $reqNom = $r->input('overtime_nominal', []);
        $reqCat = $r->input('overtime_catatan', []);
        foreach($r->employee_ids as $eid){
            $existing = Payroll::where('employee_id',$eid)->where('periode_bulan',$bulan)->where('periode_tahun',$tahun)->first();
            if(array_key_exists($eid, $reqNom)){
                $raw = $reqNom[$eid];
                $oNom = ($raw === '' || $raw === null) ? 0 : (float)$raw;
            } else {
                $oNom = $existing ? (float)$existing->total_lembur : 0;
            }
            if(array_key_exists($eid, $reqJam)){
                $raw = $reqJam[$eid];
                $oJam = ($raw === '' || $raw === null) ? 0 : (float)$raw;
            } else {
                $oJam = $existing ? (float)$existing->jam_lembur : 0;
            }
            if(array_key_exists($eid, $reqCat)){
                $raw = $reqCat[$eid];
                $oCat = ($raw === '' || $raw === null) ? null : trim((string)$raw);
            } else {
                $oCat = $existing ? $existing->catatan_lembur : null;
            }
            $calc = Payroll::hitung($eid, $bulan, $tahun, $oJam, $oNom, $oCat);
            $payroll = Payroll::updateOrCreate(
                ['employee_id'=>$eid,'periode_bulan'=>$bulan,'periode_tahun'=>$tahun],
                [
                    'gaji_pokok'=>$calc['gaji_pokok'],
                    'jml_hadir'=>$calc['jml_hadir'],
                    'bonus_kehadiran'=>$calc['bonus_kehadiran'],
                    'total_insentif'=>$calc['total_insentif'],
                    'total_potongan'=>$calc['total_potongan'],
                    'jam_lembur'=>$oJam,
                    'total_lembur'=>$oNom,
                    'catatan_lembur'=>$oCat,
                    'total_terima'=>$calc['total_terima'],
                    'status'=>'final',
                ]
            );

            // Generate signature hash dan barcode data jika belum ada
            if (!$payroll->signature_hash) {
                $company = \App\Models\CompanySetting::current();
                // signed_at diset lebih dulu: hash memakai timestamp dari signed_at
                // supaya bisa dihitung ulang saat verifikasi.
                $payroll->signed_at = now();
                $payroll->signature_hash = \App\Helpers\BarcodeGenerator::generateSignatureHash($payroll, $company);
                $payroll->barcode_data = \App\Helpers\BarcodeGenerator::generateBarcodeData($payroll, $company);
                $payroll->save();
            }
            Deduction::where('employee_id',$eid)->whereMonth('tanggal',$bulan)->whereYear('tanggal',$tahun)->where('status','belum_dipotong')->update(['status'=>'sudah_dipotong','payroll_id'=>$payroll->id]);
            $count++;
        }
        return redirect()->route('payrolls.index',['bulan'=>$bulan,'tahun'=>$tahun])->with('ok',"$count slip gaji periode $bulan/$tahun berhasil digenerate (generate ulang akan update jika sudah ada)");
    }

    public function show(Payroll $payroll){
        $payroll->load('employee');
        $insentifList = ClientAcquisition::where('employee_id',$payroll->employee_id)->whereMonth('tanggal',$payroll->periode_bulan)->whereYear('tanggal',$payroll->periode_tahun)->get();
        $potonganList = Deduction::where('payroll_id',$payroll->id)->get();
        // jika potonganList kosong (payroll lama sebelum update) fallback ambil semua potongan bulan tsb
        if($potonganList->isEmpty()){
            $potonganList = Deduction::where('employee_id',$payroll->employee_id)->whereMonth('tanggal',$payroll->periode_bulan)->whereYear('tanggal',$payroll->periode_tahun)->get();
        }
        return view('payrolls.show', compact('payroll','insentifList','potonganList'));
    }

    public function slip(Payroll $payroll){
        $payroll->load('employee');
        $insentifList = ClientAcquisition::where('employee_id',$payroll->employee_id)->whereMonth('tanggal',$payroll->periode_bulan)->whereYear('tanggal',$payroll->periode_tahun)->get();
        $potonganList = Deduction::where('payroll_id',$payroll->id)->get();
        if($potonganList->isEmpty()){
            $potonganList = Deduction::where('employee_id',$payroll->employee_id)->whereMonth('tanggal',$payroll->periode_bulan)->whereYear('tanggal',$payroll->periode_tahun)->get();
        }

        // Generate signature dan barcode jika belum ada
        if (!$payroll->signature_hash) {
            $company = \App\Models\CompanySetting::current();
            // signed_at diset lebih dulu: hash memakai timestamp dari signed_at
            // supaya bisa dihitung ulang saat verifikasi.
            $payroll->signed_at = now();
            $payroll->signature_hash = \App\Helpers\BarcodeGenerator::generateSignatureHash($payroll, $company);
            $payroll->barcode_data = \App\Helpers\BarcodeGenerator::generateBarcodeData($payroll, $company);
            $payroll->save();
        }

        return view('payrolls.slip', compact('payroll','insentifList','potonganList'));
    }

    public function destroy(Payroll $payroll){
        // kembalikan potongan ke belum_dipotong
        Deduction::where('payroll_id',$payroll->id)->update(['status'=>'belum_dipotong','payroll_id'=>null]);
        $payroll->delete();
        return back()->with('ok','Slip gaji dihapus');
    }
}

