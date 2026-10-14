<?php

namespace App\Http\Controllers;

use App\Models\VoucherTransaction;
use App\Models\Employee;
use App\Models\Presence;
use App\Models\Payroll;
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
        $karyawanAktif  = Employee::where('is_active',true)->count();
        $hadirHariIni   = Presence::whereDate('tanggal', today())->where('status','hadir')->count();

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

        return view('dashboard', compact('totalPiutang','totalLunas','transaksiBulanIni','piutangTerbaru','lunasTerbaru','karyawanAktif','hadirHariIni','chart','chartLabels','chartTotals','piutangPerReseller'));
    }
}
