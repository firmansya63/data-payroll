@extends('layouts.app')
@section('title','Dashboard')
@section('content')
<div class="flex items-center justify-between mb-4">
  <h1 class="text-xl md:text-2xl font-bold">Dashboard</h1>
  <span class="text-xs md:text-sm bg-sky-600 text-white px-3 py-1.5 rounded-full">Periode: {{ now()->translatedFormat('F Y') }}</span>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
  <div class="bg-white p-4 rounded-2xl shadow-sm border">
    <div class="text-xs text-slate-500">Total Piutang</div>
    <div class="text-lg font-bold text-red-600">Rp {{ number_format($totalPiutang,0,',','.') }}</div>
    <div class="text-xs text-slate-400">Belum Lunas</div>
  </div>
  <div class="bg-white p-4 rounded-2xl shadow-sm border">
    <div class="text-xs text-slate-500">Total Lunas</div>
    <div class="text-lg font-bold text-emerald-600">Rp {{ number_format($totalLunas,0,',','.') }}</div>
    <div class="text-xs text-slate-400">Voucher Terbayar</div>
  </div>
  <div class="bg-white p-4 rounded-2xl shadow-sm border">
    <div class="text-xs text-slate-500">Transaksi Bulan Ini</div>
    <div class="text-2xl font-bold">{{ $transaksiBulanIni }}</div>
    <div class="text-xs text-slate-400">Voucher terjual</div>
  </div>
  <div class="bg-white p-4 rounded-2xl shadow-sm border">
    <div class="text-xs text-slate-500">Karyawan Aktif</div>
    <div class="text-2xl font-bold">{{ $karyawanAktif }}</div>
    <div class="text-xs text-slate-400">{{ $hadirHariIni }} hadir hari ini</div>
  </div>
</div>

<div class="grid md:grid-cols-3 gap-4">
  <div class="md:col-span-2 bg-white p-4 md:p-5 rounded-2xl shadow-sm border">
    <div class="flex items-center justify-between gap-2 mb-4">
      <h3 class="font-semibold text-slate-800"><i class="fa-solid fa-chart-line mr-1.5 text-sky-600"></i> Penjualan 6 Bulan Terakhir</h3>
      <span class="text-[11px] text-slate-400 hidden sm:inline">Nominal voucher terjual</span>
    </div>
    @php $max = $chart->max('total') ?: 1; $sum6 = $chart->sum('total'); @endphp
    @if($sum6 == 0)
      <div class="py-12 text-center">
        <div class="w-12 h-12 mx-auto grid place-items-center bg-slate-100 rounded-full mb-3"><i class="fa-solid fa-chart-column text-slate-400"></i></div>
        <p class="text-sm font-medium text-slate-600">Belum ada penjualan 6 bulan terakhir</p>
        <p class="text-xs text-slate-400 mt-1">Grafik akan muncul setelah ada transaksi</p>
      </div>
    @else
      <div class="relative h-[230px] md:h-[260px] w-full">
        <canvas id="salesChart"></canvas>
      </div>
      <div class="mt-5 pt-4 border-t border-slate-100">
        <p class="text-[11px] font-semibold tracking-[0.12em] text-slate-400 mb-3">RINCIAN PER BULAN</p>
        <div class="space-y-2.5">
          @foreach($chart as $c)
            @php $pct = $max ? $c['total']/$max*100 : 0; $isSmall = $pct < 18 && $c['total'] > 0; $isZero = $c['total'] == 0; @endphp
            <div class="flex items-center gap-2.5">
              <span class="w-[84px] md:w-[96px] shrink-0 text-right text-xs font-medium text-slate-600 truncate" title="{{ $c['label_full'] }}">{{ $c['label'] }}</span>
              <div class="flex-1 flex items-center gap-2 min-w-0">
                <div class="flex-1 bg-slate-100 rounded-full h-7 overflow-hidden relative">
                  @if(!$isZero)
                  <div class="h-7 rounded-full flex items-center text-white text-xs font-semibold transition-all duration-500 {{ $isSmall ? 'bg-sky-500/90' : 'bg-sky-500 px-2.5 justify-between' }}" style="width:{{ max($isSmall ? 14 : 8, $pct) }}%">
                    @if(!$isSmall)
                      <span class="truncate">Rp {{ number_format($c['total'],0,',','.') }}</span>
                      @if($pct > 42)<span class="text-[10px] font-normal opacity-80 hidden sm:inline">{{ number_format($pct,0) }}%</span>@endif
                    @endif
                  </div>
                  @endif
                </div>
                <span class="shrink-0 text-xs font-semibold min-w-[96px] text-right {{ $isZero ? 'text-slate-400' : 'text-slate-700' }}" title="Rp {{ number_format($c['total'],0,',','.') }}">
                  @if($isSmall || $isZero) Rp {{ number_format($c['total'],0,',','.') }} @endif
                </span>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </div>
  <div class="bg-white p-4 rounded-2xl shadow-sm border">
    <h3 class="font-semibold mb-3"><i class="fa-solid fa-triangle-exclamation mr-1 text-amber-500"></i> Piutang Terbesar</h3>
    @forelse($piutangPerReseller as $r)
      <div class="flex justify-between items-center py-2 border-b last:border-0 text-sm">
        <span class="font-medium">{{ $r->reseller->nama ?? '-' }}</span>
        <span class="font-bold text-red-600">Rp {{ number_format($r->total,0,',','.') }}</span>
      </div>
    @empty
      <p class="text-sm text-slate-400">Tidak ada piutang</p>
    @endforelse
    <a href="{{ route('transactions.index',['status'=>'belum_lunas']) }}" class="block mt-3 text-center text-sm bg-amber-500 text-white py-2 rounded-xl">Lihat Semua Tunggakan</a>
  </div>
</div>

<div class="grid md:grid-cols-2 gap-4 mt-4">
  <div class="bg-white p-4 rounded-2xl shadow-sm border">
    <h3 class="font-semibold mb-3 text-red-600"><i class="fa-solid fa-clock mr-1"></i> 5 Tunggakan Terbaru</h3>
    <div class="space-y-2 text-sm">
      @forelse($piutangTerbaru as $t)
        <div class="flex justify-between items-center bg-red-50 p-2.5 rounded-xl">
          <div><div class="font-medium">{{ $t->reseller->nama }}</div><div class="text-xs text-slate-500">{{ $t->tanggal->format('d/m/Y') }} - Rp {{ number_format($t->nominal,0,',','.') }}</div></div>
          <a href="{{ route('transactions.index') }}" class="text-xs bg-white border px-2 py-1 rounded-lg">Tagih</a>
        </div>
      @empty <p class="text-slate-400 text-sm">Tidak ada tunggakan recent</p> @endforelse
    </div>
  </div>
  <div class="bg-white p-4 rounded-2xl shadow-sm border">
    <h3 class="font-semibold mb-3 text-emerald-600"><i class="fa-solid fa-circle-check mr-1"></i> 5 Pembayaran Lunas Terbaru</h3>
    <div class="space-y-2 text-sm">
      @forelse($lunasTerbaru as $t)
        <div class="flex justify-between items-center bg-emerald-50 p-2.5 rounded-xl">
          <div><div class="font-medium">{{ $t->reseller->nama }}</div><div class="text-xs text-slate-500">{{ $t->tanggal->format('d/m/Y') }} - Rp {{ number_format($t->nominal,0,',','.') }}</div></div>
          <span class="text-xs bg-emerald-600 text-white px-2 py-1 rounded-full">LUNAS</span>
        </div>
      @empty <p class="text-slate-400 text-sm">Belum ada transaksi lunas</p> @endforelse
    </div>
  </div>
</div>

<div class="mt-5 grid grid-cols-2 md:grid-cols-4 gap-3">
  <a href="{{ route('transactions.create') }}" class="bg-sky-600 text-white p-4 rounded-2xl text-center font-semibold"><i class="fa-solid fa-plus block text-xl mb-1"></i> Jual Voucher</a>
  <a href="{{ route('presences.bulk') }}" class="bg-indigo-600 text-white p-4 rounded-2xl text-center font-semibold"><i class="fa-solid fa-clipboard-check block text-xl mb-1"></i> Input Presensi</a>
  <a href="{{ route('acquisitions.create') }}" class="bg-emerald-600 text-white p-4 rounded-2xl text-center font-semibold"><i class="fa-solid fa-user-plus block text-xl mb-1"></i> Klien Baru</a>
  <a href="{{ route('payrolls.create') }}" class="bg-amber-500 text-white p-4 rounded-2xl text-center font-semibold"><i class="fa-solid fa-money-bill-wave block text-xl mb-1"></i> Generate Gaji</a>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  var canvas = document.getElementById('salesChart');
  if(!canvas) return;
  var labels = @json($chartLabels);
  var totals = @json($chartTotals);
  var sum = totals.reduce(function(a,b){ return a + Number(b); }, 0);
  if(sum === 0) return;
  var ctx = canvas.getContext('2d');
  var gradient = ctx.createLinearGradient(0, 0, 0, 260);
  gradient.addColorStop(0, '#0ea5e9');
  gradient.addColorStop(1, '#38bdf8');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Penjualan',
        data: totals,
        backgroundColor: gradient,
        borderRadius: 8,
        borderSkipped: false,
        barPercentage: 0.52,
        categoryPercentage: 0.72,
        hoverBackgroundColor: '#0284c7'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: { mode: 'index', intersect: false },
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#1e293b',
          titleColor: '#fff',
          bodyColor: '#fff',
          padding: 10,
          cornerRadius: 10,
          displayColors: false,
          callbacks: {
            label: function(c){ return ' Rp ' + Number(c.parsed.y).toLocaleString('id-ID'); },
            title: function(items){ return items[0].label; }
          }
        }
      },
      scales: {
        x: { grid: { display: false }, border: { display: false }, ticks: { color: '#64748b', font: { size: 11, weight: 500 } } },
        y: {
          beginAtZero: true,
          grid: { color: '#f1f5f9' },
          border: { display: false },
          ticks: {
            color: '#64748b', font: { size: 11 }, padding: 8,
            callback: function(v){
              if(v >= 1000000) return 'Rp ' + (v/1000000).toLocaleString('id-ID') + ' jt';
              if(v >= 1000) return 'Rp ' + (v/1000).toLocaleString('id-ID') + ' rb';
              return 'Rp ' + Number(v).toLocaleString('id-ID');
            }
          }
        }
      }
    }
  });
});
</script>
@endpush
