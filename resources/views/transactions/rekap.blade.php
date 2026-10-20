@extends('layouts.app')
@section('title','Rekap per Reseller')
@section('content')
<style>@media print{.no-print{display:none!important} body{background:#fff} table{font-size:11px}}</style>
<div class="relative">
  <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden no-print" aria-hidden="true">
    <div class="absolute -left-20 -top-24 h-72 w-72 rounded-full bg-indigo-300/40 blur-3xl"></div>
    <div class="absolute -right-16 top-16 h-80 w-80 rounded-full bg-fuchsia-300/30 blur-3xl"></div>
  </div>
  <div class="relative z-10">
<div class="vch-in mb-3 flex flex-wrap items-center justify-between gap-3">
  <div class="flex items-center gap-3">
    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white shadow-lg shadow-indigo-500/30"><i class="fa-solid fa-chart-pie" aria-hidden="true"></i></span>
    <div class="min-w-0">
      <h1 class="text-xl font-extrabold tracking-tight text-slate-800">Rekap Voucher per Reseller</h1>
      <p class="text-[11px] text-slate-500">Agregat piutang &amp; lunas setiap reseller.</p>
    </div>
  </div>
  <div class="no-print flex gap-2">
    <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-1 rounded-xl bg-white px-3 py-2 text-xs font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-indigo-50 hover:text-indigo-600"><i class="fa-solid fa-list" aria-hidden="true"></i> Daftar Transaksi</a>
    <button onclick="window.print()" class="inline-flex items-center gap-1 rounded-xl bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-500 px-3 py-2 text-xs font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2"><i class="fa-solid fa-print" aria-hidden="true"></i> Cetak</button>
  </div>
</div>
<p class="mb-3 text-[11px] text-slate-400">1 baris = 1 reseller (agregat semua jenis vocer). Multi-vocer 3 jenis dalam 1 tanggal tetap terjumlah ke 1 baris reseller.</p>
<form method="GET" class="no-print vch-in mb-3 rounded-3xl bg-white/80 p-3 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl md:p-4" style="animation-delay:.05s">
  <div class="grid grid-cols-2 gap-2 md:grid-cols-7">
    <input type="date" name="dari" value="{{ request('dari') }}" class="w-full rounded-xl border border-slate-200 bg-white px-2.5 py-2 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
    <input type="date" name="sampai" value="{{ request('sampai') }}" class="w-full rounded-xl border border-slate-200 bg-white px-2.5 py-2 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
    <select name="status" class="w-full rounded-xl border border-slate-200 bg-white px-2.5 py-2 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100"><option value="">Semua Status</option><option value="belum_lunas" {{ request('status')=='belum_lunas'?'selected':'' }}>Belum Lunas</option><option value="lunas" {{ request('status')=='lunas'?'selected':'' }}>Lunas</option></select>
    <select name="voucher_type" class="w-full rounded-xl border border-slate-200 bg-white px-2.5 py-2 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100"><option value="">Semua Vocer</option>@foreach($types as $k=>$t)<option value="{{ $k }}" {{ request('voucher_type')==$k?'selected':'' }}>{{ $t['label'] }}</option>@endforeach</select>
    <select name="reseller_id" class="w-full rounded-xl border border-slate-200 bg-white px-2.5 py-2 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100"><option value="">Semua Reseller</option>@foreach($resellers as $r)<option value="{{ $r->id }}" {{ request('reseller_id')==$r->id?'selected':'' }}>{{ $r->nama }}</option>@endforeach</select>
    <input name="q" value="{{ request('q') }}" placeholder="Cari reseller..." class="w-full rounded-xl border border-slate-200 bg-white px-2.5 py-2 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
    <button class="rounded-xl bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2">Filter</button>
  </div>
  <div class="mt-2 flex flex-wrap items-center gap-2 text-xs"><a href="{{ route('transactions.rekap') }}" class="inline-flex items-center gap-1 rounded-lg bg-white px-3 py-1.5 font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-indigo-50 hover:text-indigo-600"><i class="fa-solid fa-rotate-left" aria-hidden="true"></i> Reset</a><span class="rounded-full bg-indigo-50 px-2.5 py-1 font-semibold text-indigo-600 ring-1 ring-indigo-100">{{ $rows->count() }} reseller</span><span class="hidden text-slate-400 md:inline">3K:2.500 | 5K:4.000 | 10K:9.000</span></div>
</form>
<div class="vch-in overflow-hidden rounded-3xl bg-white/80 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl print:bg-white print:shadow-none print:ring-0" style="animation-delay:.1s">
<div class="overflow-x-auto">
<table class="w-full text-sm">
<thead class="bg-slate-50/80 text-[11px] uppercase tracking-wide text-slate-400"><tr>
<th class="w-8 px-2 py-2.5 text-center">No</th>
<th class="px-3 py-2.5 text-left">Reseller</th>
<th class="px-2 py-2.5 text-center">TRX</th>
<th class="px-2 py-2.5 text-center">3K</th>
<th class="px-2 py-2.5 text-center">5K</th>
<th class="px-2 py-2.5 text-center">10K</th>
<th class="px-2 py-2.5 text-center">Total Qty</th>
<th class="px-3 py-2.5 text-right">Piutang</th>
<th class="px-3 py-2.5 text-right">Lunas</th>
<th class="px-3 py-2.5 text-right">Total</th>
<th class="px-2 py-2.5 text-center no-print">Aksi</th>
</tr></thead>
<tbody>
@forelse($rows as $i=>$row)
@php $res=$row->reseller; @endphp
<tr class="border-t border-slate-100 transition hover:bg-indigo-50/40">
<td class="px-2 py-2.5 text-center text-xs text-slate-500">{{ $i+1 }}</td>
<td class="px-3 py-2.5"><div class="font-semibold text-sm leading-tight">{{ $res->nama ?? 'Reseller #'.$row->reseller_id }}</div><div class="text-xs text-slate-500">{{ $res->no_hp ?? '-' }}</div></td>
<td class="px-2 py-2.5 text-center font-semibold">{{ $row->trx_count }}</td>
<td class="px-2 py-2.5 text-center @if((int)$row->qty_3k==0) text-slate-300 @endif">{{ (int)$row->qty_3k==0 ? '-' : number_format($row->qty_3k,0,',','.') }}</td>
<td class="px-2 py-2.5 text-center @if((int)$row->qty_5k==0) text-slate-300 @endif">{{ (int)$row->qty_5k==0 ? '-' : number_format($row->qty_5k,0,',','.') }}</td>
<td class="px-2 py-2.5 text-center @if((int)$row->qty_10k==0) text-slate-300 @endif">{{ (int)$row->qty_10k==0 ? '-' : number_format($row->qty_10k,0,',','.') }}</td>
<td class="px-2 py-2.5 text-center font-bold">{{ number_format($row->total_qty,0,',','.') }}</td>
<td class="whitespace-nowrap px-3 py-2.5 text-right font-bold tabular-nums text-rose-600">Rp {{ number_format($row->piutang,0,',','.') }}</td>
<td class="whitespace-nowrap px-3 py-2.5 text-right font-bold tabular-nums text-emerald-600">Rp {{ number_format($row->lunas,0,',','.') }}</td>
<td class="whitespace-nowrap bg-indigo-50/60 px-3 py-2.5 text-right font-extrabold tabular-nums text-slate-900 print:bg-transparent">Rp {{ number_format($row->total_nominal,0,',','.') }}</td>
<td class="px-2 py-2.5 text-center no-print"><div class="flex flex-wrap justify-center gap-1"><a href="{{ route('transactions.index', array_filter(['reseller_id'=>$row->reseller_id,'dari'=>request('dari'),'sampai'=>request('sampai'),'status'=>request('status')])) }}" class="inline-flex items-center gap-1 rounded-lg bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-indigo-50 hover:text-indigo-600"><i class="fa-solid fa-eye text-[11px]" aria-hidden="true"></i> Detail</a><a href="{{ route('transactions.rekap.nota', array_filter(['reseller'=>$row->reseller_id,'dari'=>request('dari'),'sampai'=>request('sampai'),'status'=>request('status'),'voucher_type'=>request('voucher_type')])) }}" target="_blank" class="inline-flex items-center gap-1 rounded-lg bg-gradient-to-r from-indigo-600 to-violet-600 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm shadow-indigo-500/25 transition hover:brightness-110"><i class="fa-solid fa-print text-[11px]" aria-hidden="true"></i> Nota</a></div></td>
</tr>
@empty
<tr><td colspan="11" class="px-3 py-10 text-center text-slate-400 text-sm">Belum ada transaksi</td></tr>
@endforelse
</tbody>
@if($rows->isNotEmpty())
<tfoot class="bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-500 text-sm text-white print:bg-none print:bg-white print:text-slate-900"><tr>
<td colspan="2" class="px-3 py-2.5 text-right font-bold">GRAND TOTAL</td>
<td class="px-2 py-2.5 text-center font-bold">{{ number_format($grand['trx_count'],0,',','.') }}</td>
<td class="px-2 py-2.5 text-center font-bold">{{ $grand['qty_3k'] ? number_format($grand['qty_3k'],0,',','.') : '-' }}</td>
<td class="px-2 py-2.5 text-center font-bold">{{ $grand['qty_5k'] ? number_format($grand['qty_5k'],0,',','.') : '-' }}</td>
<td class="px-2 py-2.5 text-center font-bold">{{ $grand['qty_10k'] ? number_format($grand['qty_10k'],0,',','.') : '-' }}</td>
<td class="px-2 py-2.5 text-center font-bold">{{ number_format($grand['total_qty'],0,',','.') }}</td>
<td class="whitespace-nowrap px-3 py-2.5 text-right font-bold tabular-nums text-rose-100 print:text-rose-600">Rp {{ number_format($grand['piutang'],0,',','.') }}</td>
<td class="whitespace-nowrap px-3 py-2.5 text-right font-bold tabular-nums text-emerald-100 print:text-emerald-600">Rp {{ number_format($grand['lunas'],0,',','.') }}</td>
<td class="px-3 py-2.5 text-right font-bold whitespace-nowrap">Rp {{ number_format($grand['total_nominal'],0,',','.') }}</td>
<td class="no-print"></td>
</tr></tfoot>
@endif
</table>
</div>
</div>
<p class="no-print mt-2 text-[11px] text-slate-400">TRX = jumlah baris transaksi. Total = Piutang + Lunas. Cetak: Ctrl+P.</p>
  </div>
</div>
@endsection
