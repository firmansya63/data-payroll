<?php

namespace App\Http\Controllers;

use App\Models\VoucherTransaction;
use App\Models\Employee;
use App\Models\Presence;
use App\Models\Payroll;
use App\Models\ClientAcquisition;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $r)
    {
        $bulan = now()->month;
        $tahun = now()->year;

        $totalPiutang = VoucherTransaction::where('status','belum_lunas')->sum('nominal');
        $totalLunas   = VoucherTransaction::where('status','lunas')->sum('nominal');
        $transaksiBulanIni = VoucherTransaction::whereMonth('tanggal',$bulan)->whereYear('tanggal',$tahun)->count();
        $piutangTerbaru = VoucherTransaction::with('reseller')->where('status','belum_lunas')->latest('tanggal')->take(5)->get();
        $lunasTerbaru   = VoucherTransaction::with('reseller')->where('status','lunas')->latest('tanggal')->take(5)->get();

        // Karyawan aktif & Kehadiran hari ini
        $karyawanAktif = Employee::where('is_active', true)->count();
        $presencesToday = Presence::whereDate('tanggal', today())->get()->keyBy('employee_id');

        $hadirHariIni = $presencesToday->where('status', 'hadir')->count();
        $izinHariIni  = $presencesToday->whereIn('status', ['izin', 'sakit'])->count();
        $alphaHariIni = $presencesToday->where('status', 'alpha')->count();
        $belumAbsenHariIni = max(0, $karyawanAktif - $presencesToday->count());

        $attendanceRatio = $karyawanAktif > 0 ? round(($hadirHariIni / $karyawanAktif) * 100, 1) : 0;

        // Penjualan voucher hari ini
        $penjualanHariIni = (float) VoucherTransaction::whereDate('tanggal', today())->sum('nominal');

        // Estimasi payroll bulan ini (pokok + bonus hadir + insentif lembur potongan)
        $estimasiPayrollBulanIni = (float) Payroll::where('periode_bulan', $bulan)->where('periode_tahun', $tahun)->sum('total_terima');
        if ($estimasiPayrollBulanIni <= 0) {
            // Jika payroll bulan ini belum digenerate, estimasikan dari total gaji pokok karyawan aktif
            $estimasiPayrollBulanIni = (float) Employee::where('is_active', true)->sum('gaji_pokok');
        }

        // Monitoring Karyawan & Penjualan (Klien baru / insentif)
        // Ambil perolehan insentif per karyawan bulan ini & hari ini
        $acquisitionsMonth = ClientAcquisition::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->selectRaw('employee_id, COUNT(*) as total_klien, SUM(nominal_insentif) as total_insentif')
            ->groupBy('employee_id')
            ->get()
            ->keyBy('employee_id');

        $acquisitionsToday = ClientAcquisition::whereDate('tanggal', today())
            ->selectRaw('employee_id, COUNT(*) as total_klien, SUM(nominal_insentif) as total_insentif')
            ->groupBy('employee_id')
            ->get()
            ->keyBy('employee_id');

        // Daftar semua karyawan aktif untuk tabel monitoring
        $monitoringEmployees = Employee::where('is_active', true)
            ->orderBy('nama')
            ->get()
            ->map(function ($emp) use ($presencesToday, $acquisitionsToday, $acquisitionsMonth) {
                $presence = $presencesToday->get($emp->id);
                $acqToday = $acquisitionsToday->get($emp->id);
                $acqMonth = $acquisitionsMonth->get($emp->id);

                return (object) [
                    'id'               => $emp->id,
                    'nama'             => $emp->nama,
                    'jabatan'          => $emp->jabatan,
                    'no_hp'            => $emp->no_hp,
                    'presence'         => $presence,
                    'status_absen'     => $presence ? $presence->status : 'belum_absen',
                    'jam_masuk'        => $presence ? $presence->created_at->format('H:i') . ' WIB' : '-',
                    'klien_hari_ini'   => $acqToday ? (int) $acqToday->total_klien : 0,
                    'insentif_hari_ini'=> $acqToday ? (float) $acqToday->total_insentif : 0,
                    'klien_bulan_ini'  => $acqMonth ? (int) $acqMonth->total_klien : 0,
                    'insentif_bulan_ini'=> $acqMonth ? (float) $acqMonth->total_insentif : 0,
                ];
            });

        // Top Karyawan berdasarkan capaian insentif / perolehan klien bulan ini
        $topEmployees = (clone $monitoringEmployees)
            ->sortByDesc('insentif_bulan_ini')
            ->values()
            ->take(5);

        // Grafik penjualan 6 bulan terakhir - label Indonesia, siap untuk Chart.js
        $chart = collect(range(5,0))->map(function($i){
            $d = now()->subMonths($i);
            $total = VoucherTransaction::whereMonth('tanggal',$d->month)->whereYear('tanggal',$d->year)->sum('nominal');
            return ['label'=>$d->translatedFormat('M Y'),'label_full'=>$d->translatedFormat('F Y'),'total'=>(float)$total];
        });
        $chartLabels = $chart->pluck('label');
        $chartTotals = $chart->pluck('total');

        $piutangPerReseller = VoucherTransaction::selectRaw('reseller_id, SUM(nominal) as total')
            ->where('status','belum_lunas')->groupBy('reseller_id')->with('reseller')->orderByDesc('total')->take(5)->get();

        return view('dashboard', compact(
            'totalPiutang',
            'totalLunas',
            'transaksiBulanIni',
            'piutangTerbaru',
            'lunasTerbaru',
            'karyawanAktif',
            'hadirHariIni',
            'izinHariIni',
            'alphaHariIni',
            'belumAbsenHariIni',
            'attendanceRatio',
            'penjualanHariIni',
            'estimasiPayrollBulanIni',
            'monitoringEmployees',
            'topEmployees',
            'chart',
            'chartLabels',
            'chartTotals',
            'piutangPerReseller'
        ));
    }
}

