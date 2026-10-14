@extends('layouts.app')
@section('title','Penjualan Voucher')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-2 mb-3">
  <h1 class="text-lg font-bold"><i class="fa-solid fa-ticket text-[#f68b1e] mr-2"></i>Penjualan Voucher</h1>
  <a href="{{ route('transactions.create') }}" class="bg-[#1b2d4a] hover:bg-[#16233a] text-white px-4 py-2 rounded-xl text-sm font-semibold"><i class="fa-solid fa-plus mr-1"></i> Jual Voucher</a>
</div>
<div class="grid grid-cols-3 gap-2 mb-3 text-[11px]">
  @foreach($types as $k=>$t)
  <div class="border rounded-xl px-2.5 py-2 text-center {{ request('voucher_type')==$k ? 'bg-[#1b2d4a] text-white border-[#1b2d4a]' : 'bg-white' }}">
    <div class="font-bold">{{ $t['label'] }}</div>
    <div class="{{ request('voucher_type')==$k ? 'text-white/70' : 'text-slate-500' }}">Rp {{ number_format($t['reseller'],0,',','.') }}/pcs</div>
    <a href="{{ route('transactions.index', array_merge(request()->except('page'), ['voucher_type'=>$k])) }}" class="mt-1 inline-block text-[11px] underline {{ request('voucher_type')==$k ? 'text-[#f68b1e]' : 'text-sky-600' }}">Filter</a>
  </div>
  @endforeach
</div>
<div class="grid grid-cols-2 gap-3 mb-3">
  <div class="bg-red-50 border border-red-200 p-3 rounded-2xl"><div class="text-xs text-red-600">Piutang (Belum Lunas)</div><div class="font-bold text-red-700">Rp {{ number_format($sumPiutang,0,',','.') }}</div></div>
  <div class="bg-emerald-50 border border-emerald-200 p-3 rounded-2xl"><div class="text-xs text-emerald-700">Sudah Lunas</div><div class="font-bold text-emerald-700">Rp {{ number_format($sumLunas,0,',','.') }}</div></div>
</div>
<form method="GET" class="bg-white p-3 rounded-2xl shadow-sm border mb-3 space-y-2">
  <div class="grid grid-cols-2 md:grid-cols-7 gap-2">
    <select name="status" class="border rounded-xl px-2 py-2 text-sm"><option value="">Semua Status</option><option value="belum_lunas" {{ request('status')=='belum_lunas'?'selected':'' }}>Belum Lunas</option><option value="lunas" {{ request('status')=='lunas'?'selected':'' }}>Lunas</option></select>
    <select name="voucher_type" class="border rounded-xl px-2 py-2 text-sm"><option value="">Semua Vocer</option>@foreach($types as $k=>$t)<option value="{{ $k }}" {{ request('voucher_type')==$k?'selected':'' }}>{{ $t['label'] }}</option>@endforeach</select>
    <select name="reseller_id" class="border rounded-xl px-2 py-2 text-sm"><option value="">Semua Reseller</option>@foreach($resellers as $r)<option value="{{ $r->id }}" {{ request('reseller_id')==$r->id?'selected':'' }}>{{ $r->nama }}</option>@endforeach</select>
    <input type="date" name="dari" value="{{ request('dari') }}" class="border rounded-xl px-2 py-2 text-sm">
    <input type="date" name="sampai" value="{{ request('sampai') }}" class="border rounded-xl px-2 py-2 text-sm">
    <input name="q" value="{{ request('q') }}" placeholder="Cari" class="border rounded-xl px-2 py-2 text-sm">
    <button class="bg-slate-800 text-white rounded-xl px-4 py-2 text-sm">Filter</button>
  </div>
  <div class="flex flex-wrap gap-2 items-center"><a href="{{ route('transactions.index') }}" class="text-xs border px-3 py-1.5 rounded-lg bg-white">Reset</a>@if(request('status')=='belum_lunas')<span class="text-xs bg-amber-100 text-amber-800 px-3 py-1.5 rounded-full">{{ $transactions->total() }} tunggakan - Rp {{ number_format($totalPiutang,0,',','.') }}</span>@endif<span class="text-xs text-slate-400">3K:Rp2.500 | 5K:Rp4.000 | 10K:Rp9.000</span></div>
</form>
<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-sm">
<thead class="bg-slate-50 text-xs text-slate-500"><tr><th class="px-3 py-2 text-left">Tgl</th><th class="px-3 py-2 text-left">Reseller</th><th class="px-3 py-2 text-left">Vocer</th><th class="px-3 py-2 text-right">Total</th><th class="px-3 py-2">Status</th><th class="px-3 py-2">Aksi</th></tr></thead>
<tbody>
@forelse($transactions as $t)
<tr class="border-t hover:bg-slate-50">
  <td class="px-3 py-2.5 text-xs whitespace-nowrap">{{ $t->tanggal->format('d/m/y') }}</td>
  <td class="px-3 py-2"><div class="font-medium text-sm">{{ $t->reseller->nama }}</div><div class="text-xs text-slate-500">{{ Str::limit($t->keterangan,32) }}</div></td>
  <td class="px-3 py-2">@if($t->voucher_type)<span class="inline-flex items-center gap-1.5 bg-slate-900 text-white text-xs px-2 py-1 rounded-full"><i class="fa-solid fa-tag text-[10px] text-[#f68b1e]"></i> {{ $types[$t->voucher_type]['label'] ?? strtoupper($t->voucher_type) }}</span><div class="text-xs text-slate-600 mt-1">{{ $t->qty }} pcs x Rp {{ number_format($t->harga_satuan,0,',','.') }}</div>@else<span class="text-xs text-slate-500">-</span>@endif</td>
  <td class="px-3 py-2 text-right font-bold whitespace-nowrap">Rp {{ number_format($t->nominal,0,',','.') }}</td>
  <td class="px-3 py-2 text-center">@if($t->status=='lunas')<span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full text-xs font-bold">LUNAS</span>@else<span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-bold">BELUM LUNAS</span>@endif</td>
  <td class="px-3 py-2"><div class="flex gap-1 justify-center flex-wrap">@if($t->status=='belum_lunas')<form method="POST" action="{{ route('transactions.lunas',$t) }}" onsubmit="return confirm('Tandai LUNAS?')">@csrf @method('PATCH')<button class="bg-emerald-600 text-white px-2 py-1 rounded-lg text-xs font-semibold">Lunaskan</button></form>@endif<a href="{{ route('transactions.nota',$t) }}" target="_blank" class="bg-slate-800 text-white px-2 py-1 rounded-lg text-xs"><i class="fa-solid fa-print"></i></a><a href="{{ route('transactions.edit',$t) }}" class="bg-amber-100 text-amber-700 w-7 h-7 grid place-items-center rounded-lg"><i class="fa-solid fa-pen text-xs"></i></a><form method="POST" action="{{ route('transactions.destroy',$t) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="bg-red-100 text-red-600 w-7 h-7 grid place-items-center rounded-lg"><i class="fa-solid fa-trash text-xs"></i></button></form></div></td>
</tr>
@empty <tr><td colspan="6" class="px-3 py-8 text-center text-slate-400">Belum ada transaksi</td></tr> @endforelse
</tbody>
</table>
</div>
<div class="p-3 border-t">{{ $transactions->links() }}</div>
</div>
@endsection