@extends('layouts.app')
@section('title','Nota Barang & Jasa')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-2 mb-3">
  <h1 class="text-lg font-bold"><i class="fa-solid fa-receipt text-[#f68b1e] mr-2"></i>Nota Barang & Jasa</h1>
  <a href="{{ route('manual-notas.create') }}" class="bg-[#1b2d4a] hover:bg-[#16233a] text-white px-4 py-2 rounded-xl text-sm font-semibold"><i class="fa-solid fa-plus mr-1"></i> Buat Nota</a>
</div>
<div class="grid grid-cols-3 gap-2 mb-3">
  <div class="bg-red-50 border border-red-200 p-3 rounded-2xl text-center">
    <div class="text-[11px] text-red-600 font-semibold">PIUTANG (SISA)</div>
    <div class="font-bold text-red-700 text-sm">Rp {{ number_format($sumPiutang,0,',','.') }}</div>
    <div class="text-[10px] text-red-500">Belum Lunas + DP</div>
  </div>
  <div class="bg-amber-50 border border-amber-200 p-3 rounded-2xl text-center">
    <div class="text-[11px] text-amber-700 font-semibold">DP MASUK</div>
    <div class="font-bold text-amber-700 text-sm">Rp {{ number_format($sumDp,0,',','.') }}</div>
  </div>
  <div class="bg-emerald-50 border border-emerald-200 p-3 rounded-2xl text-center">
    <div class="text-[11px] text-emerald-700 font-semibold">LUNAS</div>
    <div class="font-bold text-emerald-700 text-sm">Rp {{ number_format($sumLunas,0,',','.') }}</div>
  </div>
</div>
<form method="GET" class="bg-white p-3 rounded-2xl shadow-sm border mb-3 space-y-2">
  <div class="grid grid-cols-2 md:grid-cols-7 gap-2">
    <select name="status" class="border rounded-xl px-2 py-2 text-sm">
      <option value="">Semua Status</option>
      <option value="belum_lunas" {{ request('status')=='belum_lunas'?'selected':'' }}>Belum Lunas</option>
      <option value="dp" {{ request('status')=='dp'?'selected':'' }}>DP</option>
      <option value="lunas" {{ request('status')=='lunas'?'selected':'' }}>Lunas</option>
    </select>
    <select name="jenis" class="border rounded-xl px-2 py-2 text-sm">
      <option value="">Semua Jenis</option>
      <option value="barang" {{ request('jenis')=='barang'?'selected':'' }}>Barang</option>
      <option value="jasa" {{ request('jenis')=='jasa'?'selected':'' }}>Jasa</option>
      <option value="campuran" {{ request('jenis')=='campuran'?'selected':'' }}>Campuran</option>
    </select>
    <input type="date" name="dari" value="{{ request('dari') }}" class="border rounded-xl px-2 py-2 text-sm">
    <input type="date" name="sampai" value="{{ request('sampai') }}" class="border rounded-xl px-2 py-2 text-sm">
    <input name="q" value="{{ request('q') }}" placeholder="No nota / pelanggan" class="border rounded-xl px-2 py-2 text-sm md:col-span-2">
    <button class="bg-slate-800 text-white rounded-xl px-4 py-2 text-sm">Filter</button>
  </div>
  <div class="flex flex-wrap gap-2 items-center">
    <a href="{{ route('manual-notas.index') }}" class="text-xs border px-3 py-1.5 rounded-lg bg-white">Reset</a>
    @if(request('q') || request('status') || request('jenis'))<span class="text-xs bg-slate-100 px-3 py-1.5 rounded-full">{{ $notas->total() }} nota</span>@endif
    @if(request('status')=='belum_lunas' || request('status')=='dp')<span class="text-xs bg-red-100 text-red-700 px-3 py-1.5 rounded-full">Sisa: Rp {{ number_format($totalPiutangFiltered,0,',','.') }}</span>@endif
  </div>
</form>
<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-sm">
<thead class="bg-slate-50 text-xs text-slate-500"><tr><th class="px-3 py-2 text-left">Tgl</th><th class="px-3 py-2 text-left">No Nota</th><th class="px-3 py-2 text-left">Pelanggan</th><th class="px-3 py-2 text-center">Jenis</th><th class="px-3 py-2 text-right">Total</th><th class="px-3 py-2 text-right">Sisa</th><th class="px-3 py-2 text-center">Status</th><th class="px-3 py-2 text-center">Tempo</th><th class="px-3 py-2 text-center">Aksi</th></tr></thead>
<tbody>
@forelse($notas as $n)
<tr class="border-t hover:bg-slate-50">
  <td class="px-3 py-2.5 text-xs whitespace-nowrap">{{ $n->tanggal->format('d/m/y') }}</td>
  <td class="px-3 py-2"><div class="font-mono font-bold text-xs">{{ $n->no_nota }}</div><div class="text-[11px] text-slate-500">{{ $n->items->count() }} item</div></td>
  <td class="px-3 py-2"><div class="font-medium text-sm">{{ $n->pelanggan_nama }}</div><div class="text-xs text-slate-500">{{ $n->pelanggan_hp ?? '-' }}</div></td>
  <td class="px-3 py-2 text-center">
    @if($n->jenis=='barang')<span class="bg-sky-100 text-sky-700 px-2 py-1 rounded-full text-[11px] font-bold">BARANG</span>
    @elseif($n->jenis=='jasa')<span class="bg-violet-100 text-violet-700 px-2 py-1 rounded-full text-[11px] font-bold">JASA</span>
    @else<span class="bg-amber-100 text-amber-700 px-2 py-1 rounded-full text-[11px] font-bold">CAMPURAN</span>@endif
  </td>
  <td class="px-3 py-2 text-right font-bold whitespace-nowrap">Rp {{ number_format($n->total,0,',','.') }}</td>
  <td class="px-3 py-2 text-right whitespace-nowrap {{ $n->sisa_tagihan>0?'text-red-600 font-bold':'text-slate-400' }}">Rp {{ number_format($n->sisa_tagihan,0,',','.') }}</td>
  <td class="px-3 py-2 text-center">
    @if($n->status=='lunas')<span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full text-xs font-bold">LUNAS</span>
    @elseif($n->status=='dp')<span class="bg-amber-100 text-amber-700 px-2 py-1 rounded-full text-xs font-bold">DP Rp {{ number_format($n->dp_nominal,0,',','.') }}</span>
    @else<span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-bold">BELUM LUNAS</span>@endif
  </td>
  <td class="px-3 py-2 text-center text-xs">
    @if($n->jatuh_tempo)<span class="{{ $n->is_overdue ? 'text-red-600 font-bold' : 'text-slate-600' }}">{{ $n->jatuh_tempo->format('d/m/y') }}</span>@if($n->is_overdue)<div class="text-[10px] text-red-500">Jatuh tempo</div>@endif
    @else<span class="text-slate-400">-</span>@endif
  </td>
  <td class="px-3 py-2"><div class="flex gap-1 justify-center flex-wrap">
      <a href="{{ route('manual-notas.nota',$n) }}" target="_blank" class="bg-slate-800 text-white w-7 h-7 grid place-items-center rounded-lg" title="Cetak A4 Portrait"><i class="fa-solid fa-print text-xs"></i></a>
      <a href="{{ route('manual-notas.nota-landscape',$n) }}" target="_blank" class="bg-indigo-600 text-white w-7 h-7 grid place-items-center rounded-lg" title="Cetak A4 Landscape"><i class="fa-solid fa-table-columns text-xs"></i></a>
      <a href="{{ route('manual-notas.edit',$n) }}" class="bg-amber-100 text-amber-700 w-7 h-7 grid place-items-center rounded-lg" title="Edit"><i class="fa-solid fa-pen text-xs"></i></a>
      <a href="{{ route('manual-notas.duplicate',$n) }}" class="bg-sky-100 text-sky-700 w-7 h-7 grid place-items-center rounded-lg" title="Duplikat"><i class="fa-solid fa-copy text-xs"></i></a>
      <form method="POST" action="{{ route('manual-notas.destroy',$n) }}" onsubmit="return confirm('Hapus nota {{ $n->no_nota }}?')">@csrf @method('DELETE')<button class="bg-red-100 text-red-600 w-7 h-7 grid place-items-center rounded-lg"><i class="fa-solid fa-trash text-xs"></i></button></form>
    </div></td>
</tr>
@empty <tr><td colspan="9" class="px-3 py-8 text-center text-slate-400">Belum ada nota. Klik Buat Nota.</td></tr> @endforelse
</tbody>
</table>
</div>
<div class="p-3 border-t">{{ $notas->links() }}</div>
</div>
@endsection
