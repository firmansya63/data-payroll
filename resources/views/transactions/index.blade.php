@extends('layouts.app')
@section('title','Penjualan Voucher')
@section('content')

<div class="relative">
  <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
    <div class="absolute -left-16 -top-20 h-72 w-72 rounded-full bg-blue-300/40 blur-3xl"></div>
    <div class="absolute -right-10 top-10 h-80 w-80 rounded-full bg-blue-300/30 blur-3xl"></div>
  </div>

  <div class="relative z-10">
    {{-- HERO --}}
    <section class="vch-in relative overflow-hidden rounded-3xl bg-blue-600 p-5 text-white shadow-[0_18px_45px_-18px_rgba(37,99,235,.65)] md:p-6">
      <div class="pointer-events-none absolute -right-12 -top-20 h-56 w-56 rounded-full bg-white/15 blur-2xl" aria-hidden="true"></div>
      <div class="pointer-events-none absolute -bottom-24 -left-12 h-64 w-64 rounded-full bg-blue-300/25 blur-3xl" aria-hidden="true"></div>
      <div class="relative flex flex-wrap items-start justify-between gap-4">
        <div class="min-w-0">
          <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-white/70">Transaksi</p>
          <h1 class="mt-1 flex items-center gap-2 text-2xl font-extrabold tracking-tight md:text-3xl"><i class="fa-solid fa-ticket text-white/80" aria-hidden="true"></i> Penjualan Voucher</h1>
          <p class="mt-1 text-xs text-white/75 md:text-sm">Daftar penjualan vocer per reseller beserta status pembayarannya.</p>
        </div>
        <a href="{{ route('transactions.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-white/15 px-4 py-2.5 text-sm font-semibold ring-1 ring-white/25 backdrop-blur transition hover:bg-white/25 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/60"><i class="fa-solid fa-plus" aria-hidden="true"></i> Jual Voucher</a>
      </div>
    </section>
    {{-- PILIH JENIS VOCER --}}
    <div class="mt-4 grid grid-cols-3 gap-2 text-[11px] md:gap-3">
      @foreach($types as $k=>$t)
      @php $active = request('voucher_type')==$k; @endphp
      <div class="vch-in rounded-2xl p-3 text-center transition duration-300 {{ $active ? 'bg-blue-600 text-white shadow-[0_14px_30px_-16px_rgba(37,99,235,.75)]' : 'bg-white/80 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(37,99,235,.45)] backdrop-blur-xl hover:-translate-y-1' }}" style="animation-delay:.05s">
        <div class="text-sm font-bold md:text-base">{{ $t['label'] }}</div>
        <div class="{{ $active ? 'text-white/75' : 'text-slate-400' }}">Rp {{ number_format($t['reseller'],0,',','.') }}/pcs</div>
        <a href="{{ route('transactions.index', array_merge(request()->except('page'), ['voucher_type'=>$k])) }}" class="mt-1.5 inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-[10px] font-semibold transition {{ $active ? 'bg-white/20 text-white ring-1 ring-white/30 hover:bg-white/30' : 'bg-blue-50 text-blue-600 ring-1 ring-blue-100 hover:bg-blue-100' }}"><i class="fa-solid fa-filter" aria-hidden="true"></i> Filter</a>
      </div>
      @endforeach
    </div>
    {{-- RINGKASAN --}}
    <div class="mt-3 grid grid-cols-2 gap-3">
      <div class="vch-in rounded-3xl bg-white/80 p-4 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(37,99,235,.45)] backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_40px_-18px_rgba(244,63,94,.45)]" style="animation-delay:.1s">
        <div class="flex items-start justify-between gap-1">
          <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-rose-500 to-red-500 text-white shadow-lg shadow-rose-500/30"><i class="fa-solid fa-file-invoice-dollar text-sm" aria-hidden="true"></i></span>
          <span class="whitespace-nowrap rounded-full bg-rose-50 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wide text-rose-600 ring-1 ring-rose-100">Belum lunas</span>
        </div>
        <p class="mt-3 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-400">Piutang</p>
        <p class="text-lg font-extrabold leading-tight tracking-tight text-rose-600 tabular-nums md:text-xl">Rp {{ number_format($sumPiutang,0,',','.') }}</p>
      </div>
      <div class="vch-in rounded-3xl bg-white/80 p-4 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(37,99,235,.45)] backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_40px_-18px_rgba(16,185,129,.45)]" style="animation-delay:.15s">
        <div class="flex items-start justify-between gap-1">
          <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 text-white shadow-lg shadow-emerald-500/30"><i class="fa-solid fa-circle-check text-sm" aria-hidden="true"></i></span>
          <span class="whitespace-nowrap rounded-full bg-emerald-50 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wide text-emerald-600 ring-1 ring-emerald-100">Lunas</span>
        </div>
        <p class="mt-3 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-400">Sudah Dibayar</p>
        <p class="text-lg font-extrabold leading-tight tracking-tight text-emerald-600 tabular-nums md:text-xl">Rp {{ number_format($sumLunas,0,',','.') }}</p>
      </div>
    </div>
    {{-- FILTER --}}
    <form method="GET" class="vch-in mt-3 space-y-2 rounded-3xl bg-white/80 p-3 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(37,99,235,.45)] backdrop-blur-xl md:p-4" style="animation-delay:.2s">
      <div class="grid grid-cols-2 gap-2 md:grid-cols-7">
        <select name="status" class="w-full rounded-xl border border-slate-200 bg-white px-2.5 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"><option value="">Semua Status</option><option value="belum_lunas" {{ request('status')=='belum_lunas'?'selected':'' }}>Belum Lunas</option><option value="lunas" {{ request('status')=='lunas'?'selected':'' }}>Lunas</option></select>
        <select name="voucher_type" class="w-full rounded-xl border border-slate-200 bg-white px-2.5 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"><option value="">Semua Vocer</option>@foreach($types as $k=>$t)<option value="{{ $k }}" {{ request('voucher_type')==$k?'selected':'' }}>{{ $t['label'] }}</option>@endforeach</select>
        <select name="reseller_id" class="w-full rounded-xl border border-slate-200 bg-white px-2.5 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"><option value="">Semua Reseller</option>@foreach($resellers as $r)<option value="{{ $r->id }}" {{ request('reseller_id')==$r->id?'selected':'' }}>{{ $r->nama }}</option>@endforeach</select>
        <input type="date" name="dari" value="{{ request('dari') }}" class="w-full rounded-xl border border-slate-200 bg-white px-2.5 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
        <input type="date" name="sampai" value="{{ request('sampai') }}" class="w-full rounded-xl border border-slate-200 bg-white px-2.5 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
        <input name="q" value="{{ request('q') }}" placeholder="Cari" class="w-full rounded-xl border border-slate-200 bg-white px-2.5 py-2 text-sm text-slate-700 placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
        <button class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-blue-600/25 transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">Filter</button>
      </div>
      <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-1 rounded-lg bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-blue-50 hover:text-blue-600"><i class="fa-solid fa-rotate-left" aria-hidden="true"></i> Reset</a>
        @if(request('status')=='belum_lunas')<span class="inline-flex items-center gap-1 rounded-full bg-gradient-to-r from-amber-400 to-orange-500 px-3 py-1.5 text-xs font-semibold text-white shadow-sm shadow-amber-500/30"><i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i> {{ $transactions->total() }} tunggakan - Rp {{ number_format($totalPiutang,0,',','.') }}</span>@endif
        <span class="text-xs text-slate-400">3K:Rp2.500 | 5K:Rp4.000 | 10K:Rp9.000</span>
      </div>
    </form>
    {{-- TABEL --}}
    <div class="vch-in mt-3 overflow-hidden rounded-3xl bg-white/80 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(37,99,235,.45)] backdrop-blur-xl" style="animation-delay:.25s">
    <div class="overflow-x-auto">
    <table class="w-full text-sm">
    <thead class="bg-slate-50/80 text-[11px] uppercase tracking-wide text-slate-400"><tr><th class="px-3 py-2.5 text-left">Tgl</th><th class="px-3 py-2.5 text-left">Reseller</th><th class="px-3 py-2.5 text-left">Vocer</th><th class="px-3 py-2.5 text-right">Total</th><th class="px-3 py-2.5 text-center">Status</th><th class="px-3 py-2.5 text-center">Aksi</th></tr></thead>
    <tbody>
    @forelse($transactions as $t)
    <tr class="border-t border-slate-100 transition hover:bg-blue-50/40">
      <td class="px-3 py-2.5 text-xs whitespace-nowrap text-slate-500">{{ $t->tanggal->format('d/m/y') }}</td>
      <td class="px-3 py-2"><div class="text-sm font-semibold text-slate-800">{{ $t->reseller->nama }}</div><div class="text-xs text-slate-400">{{ Str::limit($t->keterangan,32) }}</div></td>
      <td class="px-3 py-2">@if($t->voucher_type)<span class="inline-flex items-center gap-1.5 rounded-full bg-blue-600 px-2 py-1 text-xs font-semibold text-white shadow-sm shadow-blue-600/25"><i class="fa-solid fa-tag text-[10px] text-blue-200" aria-hidden="true"></i> {{ $types[$t->voucher_type]['label'] ?? strtoupper($t->voucher_type) }}</span><div class="mt-1 text-xs text-slate-500">{{ $t->qty }} pcs x Rp {{ number_format($t->harga_satuan,0,',','.') }}</div>@else<span class="text-xs text-slate-400">-</span>@endif</td>
      <td class="px-3 py-2 text-right font-bold whitespace-nowrap tabular-nums text-slate-800">Rp {{ number_format($t->nominal,0,',','.') }}</td>
      <td class="px-3 py-2 text-center">@if($t->status=='lunas')<span class="inline-flex items-center gap-1 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 px-2 py-1 text-[10px] font-bold uppercase tracking-wide text-white shadow-sm shadow-emerald-500/30"><i class="fa-solid fa-check text-[9px]" aria-hidden="true"></i> Lunas</span>@else<span class="inline-flex items-center gap-1 rounded-full bg-rose-100 px-2 py-1 text-[10px] font-bold uppercase tracking-wide text-rose-700 ring-1 ring-rose-200"><i class="fa-solid fa-clock text-[9px]" aria-hidden="true"></i> Belum Lunas</span>@endif</td>
      <td class="px-3 py-2">
        <div class="flex items-center justify-center gap-1.5">
          @if($t->status=='belum_lunas')
          <form method="POST" action="{{ route('transactions.lunas',$t) }}" onsubmit="return confirm('Tandai LUNAS?')">
            @csrf @method('PATCH')
            <button type="submit" title="Tandai Lunas" aria-label="Tandai Lunas"
                    class="inline-flex h-8 items-center gap-1.5 rounded-lg bg-emerald-600 px-2.5 text-xs font-semibold text-white shadow-sm shadow-emerald-600/30 transition hover:bg-emerald-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-1">
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
              Lunaskan
            </button>
          </form>
          @endif
          <a href="{{ route('transactions.nota',$t) }}" target="_blank" rel="noopener" title="Cetak Nota" aria-label="Cetak Nota"
             class="grid h-8 w-8 place-items-center rounded-lg bg-blue-600 text-white shadow-sm shadow-blue-600/30 transition hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-1">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9V4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v5"/><path d="M6 18H4a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="7" rx="1"/></svg>
          </a>
          <a href="{{ route('transactions.edit',$t) }}" title="Edit Transaksi" aria-label="Edit Transaksi"
             class="grid h-8 w-8 place-items-center rounded-lg bg-amber-50 text-amber-600 ring-1 ring-amber-100 transition hover:bg-amber-100 hover:text-amber-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-1">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"/></svg>
          </a>
          <form method="POST" action="{{ route('transactions.destroy',$t) }}" onsubmit="return confirm('Hapus?')">
            @csrf @method('DELETE')
            <button type="submit" title="Hapus Transaksi" aria-label="Hapus Transaksi"
                    class="grid h-8 w-8 place-items-center rounded-lg bg-rose-50 text-rose-600 ring-1 ring-rose-100 transition hover:bg-rose-100 hover:text-rose-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500 focus-visible:ring-offset-1">
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
            </button>
          </form>
        </div>
      </td>
    </tr>
    @empty <tr><td colspan="6" class="px-3 py-10 text-center text-sm text-slate-400"><span class="mx-auto mb-2 grid h-11 w-11 place-items-center rounded-2xl bg-blue-50 text-blue-600 ring-1 ring-blue-100"><i class="fa-solid fa-ticket" aria-hidden="true"></i></span>Belum ada transaksi</td></tr> @endforelse
    </tbody>
    </table>
    </div>
    <div class="border-t border-slate-100 p-3">{{ $transactions->links() }}</div>
    </div>
  </div>
</div>
@endsection