@extends('layouts.app')
@section('title','Dashboard')
@section('content')
<style>
  @keyframes dashFadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
  .dash-in{animation:dashFadeUp .55s cubic-bezier(.22,1,.36,1) both}
  @media (prefers-reduced-motion:reduce){.dash-in{animation:none!important;transition:none!important}}
</style>

<div class="relative">
  <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
    <div class="absolute -left-16 -top-20 h-72 w-72 rounded-full bg-indigo-300/40 blur-3xl"></div>
    <div class="absolute -right-10 top-10 h-80 w-80 rounded-full bg-fuchsia-300/30 blur-3xl"></div>
    <div class="absolute left-1/3 top-[420px] h-72 w-72 rounded-full bg-violet-300/25 blur-3xl"></div>
  </div>

  <div class="relative z-10">
    {{-- HERO --}}
    <section class="dash-in relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-violet-600 to-fuchsia-500 p-5 text-white shadow-[0_18px_45px_-18px_rgba(99,102,241,.65)] md:p-7">
      <div class="pointer-events-none absolute -right-12 -top-20 h-56 w-56 rounded-full bg-white/15 blur-2xl" aria-hidden="true"></div>
      <div class="pointer-events-none absolute -bottom-24 -left-12 h-64 w-64 rounded-full bg-fuchsia-300/25 blur-3xl" aria-hidden="true"></div>
      <div class="relative flex flex-wrap items-start justify-between gap-4">
        <div class="min-w-0">
          <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-white/70">Halo, {{ Auth::user()->name }}</p>
          <h1 class="mt-1 text-2xl font-extrabold tracking-tight md:text-3xl">Dashboard</h1>
          <p class="mt-1 text-xs text-white/75 md:text-sm">Ringkasan voucher, piutang, dan payroll dalam satu tampilan.</p>
        </div>
        <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3.5 py-1.5 text-xs font-semibold ring-1 ring-white/25 backdrop-blur">
          <i class="fa-regular fa-calendar" aria-hidden="true"></i> Periode {{ now()->translatedFormat('F Y') }}
        </span>
      </div>
    </section>

    {{-- KPI --}}
    <div class="mt-4 grid grid-cols-2 gap-3 md:grid-cols-4 md:gap-4">
      <div class="dash-in rounded-3xl bg-white/80 p-4 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_40px_-18px_rgba(244,63,94,.45)] md:p-5" style="animation-delay:.05s">
        <div class="flex items-start justify-between gap-1">
          <span class="grid h-10 w-10 place-items-center rounded-2xl bg-gradient-to-br from-rose-500 to-red-500 text-white shadow-lg shadow-rose-500/30"><i class="fa-solid fa-file-invoice-dollar text-sm" aria-hidden="true"></i></span>
          <span class="min-w-0 max-w-[calc(100%-2.75rem)] rounded-full bg-rose-50 px-2 py-0.5 text-center text-[9px] font-bold uppercase leading-tight tracking-wide text-rose-600 ring-1 ring-rose-100 sm:text-[10px]">Belum lunas</span>
        </div>
        <p class="mt-3 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-400">Total Piutang</p>
        <p class="text-[15px] font-extrabold leading-tight tracking-tight text-slate-800 tabular-nums sm:text-lg md:text-xl">Rp {{ number_format($totalPiutang,0,',','.') }}</p>
        <p class="mt-0.5 text-[11px] text-slate-400">Total tagihan berjalan</p>
      </div>

      <div class="dash-in rounded-3xl bg-white/80 p-4 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_40px_-18px_rgba(16,185,129,.45)] md:p-5" style="animation-delay:.1s">
        <div class="flex items-start justify-between gap-1">
          <span class="grid h-10 w-10 place-items-center rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 text-white shadow-lg shadow-emerald-500/30"><i class="fa-solid fa-circle-check text-sm" aria-hidden="true"></i></span>
          <span class="whitespace-nowrap rounded-full bg-emerald-50 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wide text-emerald-600 ring-1 ring-emerald-100 sm:text-[10px]">Lunas</span>
        </div>
        <p class="mt-3 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-400">Total Lunas</p>
        <p class="text-[15px] font-extrabold leading-tight tracking-tight text-slate-800 tabular-nums sm:text-lg md:text-xl">Rp {{ number_format($totalLunas,0,',','.') }}</p>
        <p class="mt-0.5 text-[11px] text-slate-400">Voucher terbayar</p>
      </div>

      <div class="dash-in rounded-3xl bg-white/80 p-4 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_40px_-18px_rgba(99,102,241,.45)] md:p-5" style="animation-delay:.15s">
        <div class="flex items-start justify-between gap-1">
          <span class="grid h-10 w-10 place-items-center rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white shadow-lg shadow-indigo-500/30"><i class="fa-solid fa-ticket text-sm" aria-hidden="true"></i></span>
          <span class="whitespace-nowrap rounded-full bg-indigo-50 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wide text-indigo-600 ring-1 ring-indigo-100 sm:text-[10px]">Bulan ini</span>
        </div>
        <p class="mt-3 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-400">Transaksi</p>
        <p class="text-lg font-extrabold leading-tight tracking-tight text-slate-800 tabular-nums md:text-xl">{{ number_format($transaksiBulanIni,0,',','.') }}</p>
        <p class="mt-0.5 text-[11px] text-slate-400">Voucher terjual</p>
      </div>

      <div class="dash-in rounded-3xl bg-white/80 p-4 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_40px_-18px_rgba(245,158,11,.45)] md:p-5" style="animation-delay:.2s">
        <div class="flex items-start justify-between gap-1">
          <span class="grid h-10 w-10 place-items-center rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 text-white shadow-lg shadow-amber-500/30"><i class="fa-solid fa-users text-sm" aria-hidden="true"></i></span>
          <span class="whitespace-nowrap rounded-full bg-amber-50 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wide text-amber-600 ring-1 ring-amber-100 sm:text-[10px]">Aktif</span>
        </div>
        <p class="mt-3 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-400">Karyawan</p>
        <p class="text-lg font-extrabold leading-tight tracking-tight text-slate-800 tabular-nums md:text-xl">{{ number_format($karyawanAktif,0,',','.') }}</p>
        <p class="mt-0.5 text-[11px] text-slate-400">{{ $hadirHariIni }} hadir hari ini</p>
      </div>
    </div>
    {{-- GRAFIK & PIUTANG --}}
    <div class="mt-4 grid gap-4 md:grid-cols-3">
      <section class="dash-in rounded-3xl bg-white/80 p-4 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] ring-1 ring-white/70 backdrop-blur-xl md:col-span-2 md:p-5" style="animation-delay:.25s">
        <div class="mb-4 flex items-center justify-between gap-2">
          <div class="flex items-center gap-2.5">
            <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white shadow-lg shadow-indigo-500/30"><i class="fa-solid fa-chart-line text-sm" aria-hidden="true"></i></span>
            <div>
              <h3 class="font-bold leading-tight text-slate-800">Penjualan 6 Bulan Terakhir</h3>
              <p class="text-[11px] text-slate-400">Nominal voucher terjual</p>
            </div>
          </div>
          <span class="hidden shrink-0 rounded-full bg-indigo-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-indigo-600 ring-1 ring-indigo-100 sm:inline">6 bulan</span>
        </div>
        @php $max = $chart->max('total') ?: 1; $sum6 = $chart->sum('total'); @endphp
        @if($sum6 == 0)
          <div class="py-12 text-center">
            <div class="mx-auto mb-3 grid h-14 w-14 place-items-center rounded-2xl bg-gradient-to-br from-indigo-50 to-fuchsia-50 text-indigo-400 ring-1 ring-indigo-100"><i class="fa-solid fa-chart-column text-lg" aria-hidden="true"></i></div>
            <p class="text-sm font-semibold text-slate-600">Belum ada penjualan 6 bulan terakhir</p>
            <p class="mt-1 text-xs text-slate-400">Grafik akan muncul setelah ada transaksi</p>
          </div>
        @else
          <div class="relative h-[230px] w-full md:h-[260px]"><canvas id="salesChart"></canvas></div>
          <div class="mt-5 border-t border-slate-100 pt-4">
            <p class="mb-3 text-[11px] font-semibold tracking-[0.12em] text-slate-400">RINCIAN PER BULAN</p>
            <div class="space-y-2.5">
              @foreach($chart as $c)
                @php $pct = $max ? $c['total']/$max*100 : 0; $isSmall = $pct < 18 && $c['total'] > 0; $isZero = $c['total'] == 0; @endphp
                <div class="flex items-center gap-2.5">
                  <span class="w-[84px] shrink-0 truncate text-right text-xs font-medium text-slate-500 md:w-[96px]" title="{{ $c['label_full'] }}">{{ $c['label'] }}</span>
                  <div class="flex min-w-0 flex-1 items-center gap-2">
                    <div class="relative h-7 flex-1 overflow-hidden rounded-full bg-slate-100">
                      @if(!$isZero)
                        <div class="flex h-7 items-center rounded-full bg-gradient-to-r from-indigo-500 to-fuchsia-500 text-xs font-semibold text-white transition-all duration-700 {{ $isSmall ? '' : 'justify-between px-2.5' }}" style="width:{{ max($isSmall ? 14 : 8, $pct) }}%">
                          @if(!$isSmall)
                            <span class="truncate">Rp {{ number_format($c['total'],0,',','.') }}</span>
                            @if($pct > 42)<span class="hidden text-[10px] font-normal opacity-80 sm:inline">{{ number_format($pct,0) }}%</span>@endif
                          @endif
                        </div>
                      @endif
                    </div>
                    <span class="shrink-0 text-right text-xs font-semibold tabular-nums min-w-[96px] {{ $isZero ? 'text-slate-400' : 'text-slate-700' }}" title="Rp {{ number_format($c['total'],0,',','.') }}">
                      @if($isSmall || $isZero) Rp {{ number_format($c['total'],0,',','.') }} @endif
                    </span>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif
      </section>
      <section class="dash-in rounded-3xl bg-white/80 p-4 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] ring-1 ring-white/70 backdrop-blur-xl md:p-5" style="animation-delay:.3s">
        <div class="mb-3 flex items-center gap-2.5">
          <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 text-white shadow-lg shadow-amber-500/30"><i class="fa-solid fa-triangle-exclamation text-sm" aria-hidden="true"></i></span>
          <div>
            <h3 class="font-bold leading-tight text-slate-800">Piutang Terbesar</h3>
            <p class="text-[11px] text-slate-400">Belum lunas per reseller</p>
          </div>
        </div>
        @forelse($piutangPerReseller as $r)
          <div class="flex items-center gap-2.5 border-b border-slate-100 py-2.5 last:border-0">
            <span class="grid h-7 w-7 shrink-0 place-items-center rounded-lg bg-gradient-to-br from-rose-500 to-orange-400 text-[10px] font-bold text-white">{{ $loop->iteration }}</span>
            <span class="min-w-0 flex-1 truncate text-sm font-medium text-slate-700">{{ $r->reseller->nama ?? '-' }}</span>
            <span class="shrink-0 text-xs font-bold tabular-nums text-rose-600">Rp {{ number_format($r->total,0,',','.') }}</span>
          </div>
        @empty
          <div class="py-8 text-center">
            <div class="mx-auto mb-2 grid h-11 w-11 place-items-center rounded-2xl bg-emerald-50 text-emerald-500 ring-1 ring-emerald-100"><i class="fa-solid fa-check" aria-hidden="true"></i></div>
            <p class="text-sm text-slate-400">Tidak ada piutang</p>
          </div>
        @endforelse
        <a href="{{ route('transactions.index',['status'=>'belum_lunas']) }}" class="mt-3 block rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 py-2 text-center text-sm font-semibold text-white shadow-lg shadow-amber-500/25 transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2">Lihat Semua Tunggakan</a>
      </section>
    </div>

    {{-- DAFTAR TERBARU --}}
    <div class="mt-4 grid gap-4 md:grid-cols-2">
      <section class="dash-in rounded-3xl bg-white/80 p-4 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] ring-1 ring-white/70 backdrop-blur-xl md:p-5" style="animation-delay:.35s">
        <div class="mb-3 flex items-center justify-between gap-2">
          <div class="flex items-center gap-2.5">
            <span class="grid h-9 w-9 place-items-center rounded-xl bg-rose-50 text-rose-500 ring-1 ring-rose-100"><i class="fa-solid fa-clock text-sm" aria-hidden="true"></i></span>
            <div>
              <h3 class="font-bold leading-tight text-slate-800">5 Tunggakan Terbaru</h3>
              <p class="text-[11px] text-slate-400">Perlu ditagih</p>
            </div>
          </div>
          <a href="{{ route('transactions.index',['status'=>'belum_lunas']) }}" class="shrink-0 text-[11px] font-semibold text-rose-600 hover:underline">Lihat semua</a>
        </div>
        <div class="space-y-2 text-sm">
          @forelse($piutangTerbaru as $t)
            <div class="flex items-center justify-between gap-2 rounded-2xl bg-gradient-to-r from-rose-50 to-orange-50 p-3 ring-1 ring-rose-100/70">
              <div class="min-w-0">
                <div class="truncate font-semibold text-slate-800">{{ $t->reseller->nama ?? '-' }}</div>
                <div class="mt-0.5 text-xs text-slate-500">{{ $t->tanggal->format('d/m/Y') }} &middot; Rp {{ number_format($t->nominal,0,',','.') }}</div>
              </div>
              <a href="{{ route('transactions.index') }}" class="shrink-0 rounded-lg bg-white px-2.5 py-1.5 text-[11px] font-semibold text-rose-600 ring-1 ring-rose-200 transition hover:bg-rose-600 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-300">Tagih</a>
            </div>
          @empty
            <p class="py-4 text-center text-sm text-slate-400">Tidak ada tunggakan recent</p>
          @endforelse
        </div>
      </section>
      <section class="dash-in rounded-3xl bg-white/80 p-4 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] ring-1 ring-white/70 backdrop-blur-xl md:p-5" style="animation-delay:.4s">
        <div class="mb-3 flex items-center justify-between gap-2">
          <div class="flex items-center gap-2.5">
            <span class="grid h-9 w-9 place-items-center rounded-xl bg-emerald-50 text-emerald-500 ring-1 ring-emerald-100"><i class="fa-solid fa-circle-check text-sm" aria-hidden="true"></i></span>
            <div>
              <h3 class="font-bold leading-tight text-slate-800">5 Pembayaran Lunas</h3>
              <p class="text-[11px] text-slate-400">Transaksi terbaru</p>
            </div>
          </div>
          <a href="{{ route('transactions.index',['status'=>'lunas']) }}" class="shrink-0 text-[11px] font-semibold text-emerald-600 hover:underline">Lihat semua</a>
        </div>
        <div class="space-y-2 text-sm">
          @forelse($lunasTerbaru as $t)
            <div class="flex items-center justify-between gap-2 rounded-2xl bg-gradient-to-r from-emerald-50 to-teal-50 p-3 ring-1 ring-emerald-100/70">
              <div class="min-w-0">
                <div class="truncate font-semibold text-slate-800">{{ $t->reseller->nama ?? '-' }}</div>
                <div class="mt-0.5 text-xs text-slate-500">{{ $t->tanggal->format('d/m/Y') }} &middot; Rp {{ number_format($t->nominal,0,',','.') }}</div>
              </div>
              <span class="shrink-0 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-white shadow-sm shadow-emerald-500/30">Lunas</span>
            </div>
          @empty
            <p class="py-4 text-center text-sm text-slate-400">Belum ada transaksi lunas</p>
          @endforelse
        </div>
      </section>
    </div>

    {{-- QUICK ACTIONS --}}
    <div class="mt-5 grid grid-cols-2 gap-3 md:grid-cols-4 md:gap-4">
      <a href="{{ route('transactions.create') }}" class="dash-in group relative overflow-hidden rounded-2xl bg-gradient-to-br from-sky-500 to-indigo-600 p-4 text-center font-semibold text-white shadow-lg shadow-sky-500/25 transition duration-300 hover:-translate-y-1 hover:shadow-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-400 focus-visible:ring-offset-2" style="animation-delay:.45s">
        <span class="pointer-events-none absolute -right-6 -top-6 h-20 w-20 rounded-full bg-white/10" aria-hidden="true"></span>
        <span class="relative mx-auto mb-2 grid h-9 w-9 place-items-center rounded-xl bg-white/15 ring-1 ring-white/25"><i class="fa-solid fa-plus" aria-hidden="true"></i></span>
        <span class="relative block text-sm">Jual Voucher</span>
      </a>
      <a href="{{ route('presences.bulk') }}" class="dash-in group relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 p-4 text-center font-semibold text-white shadow-lg shadow-indigo-500/25 transition duration-300 hover:-translate-y-1 hover:shadow-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2" style="animation-delay:.5s">
        <span class="pointer-events-none absolute -right-6 -top-6 h-20 w-20 rounded-full bg-white/10" aria-hidden="true"></span>
        <span class="relative mx-auto mb-2 grid h-9 w-9 place-items-center rounded-xl bg-white/15 ring-1 ring-white/25"><i class="fa-solid fa-clipboard-check" aria-hidden="true"></i></span>
        <span class="relative block text-sm">Input Presensi</span>
      </a>
      <a href="{{ route('acquisitions.create') }}" class="dash-in group relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 p-4 text-center font-semibold text-white shadow-lg shadow-emerald-500/25 transition duration-300 hover:-translate-y-1 hover:shadow-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400 focus-visible:ring-offset-2" style="animation-delay:.55s">
        <span class="pointer-events-none absolute -right-6 -top-6 h-20 w-20 rounded-full bg-white/10" aria-hidden="true"></span>
        <span class="relative mx-auto mb-2 grid h-9 w-9 place-items-center rounded-xl bg-white/15 ring-1 ring-white/25"><i class="fa-solid fa-user-plus" aria-hidden="true"></i></span>
        <span class="relative block text-sm">Klien Baru</span>
      </a>
      <a href="{{ route('payrolls.create') }}" class="dash-in group relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 p-4 text-center font-semibold text-white shadow-lg shadow-amber-500/25 transition duration-300 hover:-translate-y-1 hover:shadow-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2" style="animation-delay:.6s">
        <span class="pointer-events-none absolute -right-6 -top-6 h-20 w-20 rounded-full bg-white/10" aria-hidden="true"></span>
        <span class="relative mx-auto mb-2 grid h-9 w-9 place-items-center rounded-xl bg-white/15 ring-1 ring-white/25"><i class="fa-solid fa-money-bill-wave" aria-hidden="true"></i></span>
        <span class="relative block text-sm">Generate Gaji</span>
      </a>
    </div>
  </div>
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
  gradient.addColorStop(0, '#6366f1');
  gradient.addColorStop(1, '#d946ef');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Penjualan',
        data: totals,
        backgroundColor: gradient,
        borderRadius: 10,
        borderSkipped: false,
        barPercentage: 0.5,
        categoryPercentage: 0.7,
        hoverBackgroundColor: '#7c3aed'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: { mode: 'index', intersect: false },
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#0f172a',
          titleColor: '#fff',
          bodyColor: '#e2e8f0',
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
          grid: { color: '#eef2ff' },
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







