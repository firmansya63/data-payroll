@extends('layouts.app')
@section('title','Kasbon / Potongan')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-2 mb-3">
  <h1 class="text-lg font-bold"><i class="fa-solid fa-hand-holding-dollar text-amber-600 mr-2"></i>Kasbon / Potongan</h1>
  <a href="{{ route('deductions.create') }}" class="bg-amber-500 text-white px-4 py-2 rounded-xl text-sm font-semibold"><i class="fa-solid fa-plus mr-1"></i> Catat Kasbon</a>
</div>
<div class="bg-amber-50 border border-amber-200 p-3 rounded-2xl mb-3 flex justify-between items-center">
  <div><div class="text-xs text-amber-700">Total Potongan (filter ini)</div><div class="font-bold text-amber-800">Rp {{ number_format($total,0,',','.') }}</div></div>
  <span class="text-xs bg-white border px-2 py-1 rounded-full">Rumus: Gaji = Pokok + BonusHadir + Insentif - Potongan</span>
</div>
<form method="GET" class="bg-white p-3 rounded-2xl shadow-sm border mb-3 grid grid-cols-2 md:grid-cols-6 gap-2">
  <select name="employee_id" class="border rounded-xl px-2 py-2 text-sm"><option value="">Semua Karyawan</option>@foreach($employees as $e)<option value="{{ $e->id }}" {{ request('employee_id')==$e->id?'selected':'' }}>{{ $e->nama }}</option>@endforeach</select>
  <select name="bulan" class="border rounded-xl px-2 py-2 text-sm"><option value="">Semua Bulan</option>@for($m=1;$m<=12;$m++)<option value="{{ $m }}" {{ request('bulan')==$m?'selected':'' }}>{{ DateTime::createFromFormat('!m',$m)->format('F') }}</option>@endfor</select>
  <select name="tahun" class="border rounded-xl px-2 py-2 text-sm"><option value="">Semua Tahun</option>@for($y=now()->year-1;$y<=now()->year+1;$y++)<option value="{{ $y }}" {{ request('tahun')==$y?'selected':'' }}>{{ $y }}</option>@endfor</select>
  <select name="status" class="border rounded-xl px-2 py-2 text-sm"><option value="">Semua Status</option><option value="belum_dipotong" {{ request('status')=='belum_dipotong'?'selected':'' }}>Belum Dipotong</option><option value="sudah_dipotong" {{ request('status')=='sudah_dipotong'?'selected':'' }}>Sudah Dipotong</option></select>
  <button class="bg-slate-800 text-white rounded-xl px-4 py-2 text-sm">Filter</button>
  <a href="{{ route('deductions.index') }}" class="border rounded-xl px-4 py-2 text-sm text-center">Reset</a>
</form>
<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-sm">
<thead class="bg-slate-50 text-xs text-slate-500"><tr><th class="px-3 py-2 text-left">Tgl</th><th class="px-3 py-2 text-left">Karyawan</th><th class="px-3 py-2">Ket</th><th class="px-3 py-2 text-right">Nominal</th><th class="px-3 py-2">Status</th><th class="px-3 py-2">Aksi</th></tr></thead>
<tbody>
@forelse($items as $it)
<tr class="border-t">
  <td class="px-3 py-2.5 text-xs">{{ $it->tanggal->format('d/m/y') }}</td>
  <td class="px-3 py-2 font-medium">{{ $it->employee->nama }}</td>
  <td class="px-3 py-2 text-xs">{{ $it->keterangan ?? '-' }}</td>
  <td class="px-3 py-2 text-right font-bold text-red-600">Rp {{ number_format($it->nominal,0,',','.') }}</td>
  <td class="px-3 py-2 text-center">@if($it->status=='belum_dipotong')<span class="bg-amber-100 text-amber-700 px-2 py-1 rounded-full text-xs">Belum Dipotong</span>@else<span class="bg-slate-100 text-slate-600 px-2 py-1 rounded-full text-xs">Sudah Dipotong</span>@endif</td>
  <td class="px-3 py-2"><div class="flex items-center justify-center gap-1.5"><a href="{{ route('deductions.edit',$it) }}" title="Edit Potongan / Kasbon" aria-label="Edit Potongan / Kasbon" class="grid h-8 w-8 place-items-center rounded-lg bg-amber-50 text-amber-600 ring-1 ring-amber-100 transition hover:bg-amber-100 hover:text-amber-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-1"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"/></svg></a><form method="POST" action="{{ route('deductions.destroy',$it) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" title="Hapus Potongan / Kasbon" aria-label="Hapus Potongan / Kasbon" class="grid h-8 w-8 place-items-center rounded-lg bg-rose-50 text-rose-600 ring-1 ring-rose-100 transition hover:bg-rose-100 hover:text-rose-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500 focus-visible:ring-offset-1"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg></button></form></div></td>
</tr>
@empty<tr><td colspan="6" class="px-3 py-8 text-center text-slate-400">Belum ada potongan/kasbon</td></tr>@endforelse
</tbody>
</table>
</div>
<div class="p-3 border-t">{{ $items->links() }}</div>
</div>
@endsection
