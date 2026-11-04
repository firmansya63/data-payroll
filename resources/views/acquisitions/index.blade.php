@extends('layouts.app')
@section('title','Klien Baru')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-2 mb-3">
  <h1 class="text-lg font-bold"><i class="fa-solid fa-user-plus text-emerald-600 mr-2"></i>Klien Baru (Insentif)</h1>
  <a href="{{ route('acquisitions.create') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm font-semibold"><i class="fa-solid fa-plus mr-1"></i> Catat Klien</a>
</div>
<div class="bg-emerald-50 border border-emerald-200 p-3 rounded-2xl mb-3">
  <div class="text-xs text-emerald-700">Total Insentif (filter ini)</div>
  <div class="font-bold text-emerald-800">Rp {{ number_format($totalInsentif,0,',','.') }}</div>
</div>
<form method="GET" class="bg-white p-3 rounded-2xl shadow-sm border mb-3 grid grid-cols-2 md:grid-cols-6 gap-2">
  <select name="employee_id" class="border rounded-xl px-2 py-2 text-sm"><option value="">Semua Karyawan</option>@foreach($employees as $e)<option value="{{ $e->id }}" {{ request('employee_id')==$e->id?'selected':''}}>{{ $e->nama }}</option>@endforeach</select>
  <select name="bulan" class="border rounded-xl px-2 py-2 text-sm"><option value="">Semua Bulan</option>@for($m=1;$m<=12;$m++)<option value="{{ $m }}" {{ request('bulan')==$m?'selected':'' }}>{{ DateTime::createFromFormat('!m',$m)->format('F') }}</option>@endfor</select>
  <select name="tahun" class="border rounded-xl px-2 py-2 text-sm"><option value="">Semua Tahun</option>@for($y=now()->year-1;$y<=now()->year+1;$y++)<option value="{{ $y }}" {{ request('tahun')==$y?'selected':'' }}>{{ $y }}</option>@endfor</select>
  <input name="q" value="{{ request('q') }}" placeholder="Cari klien..." class="border rounded-xl px-2 py-2 text-sm">
  <button class="bg-slate-800 text-white rounded-xl px-4 py-2 text-sm">Filter</button>
  <a href="{{ route('acquisitions.index') }}" class="border rounded-xl px-4 py-2 text-sm text-center">Reset</a>
</form>
<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-sm">
<thead class="bg-slate-50 text-xs text-slate-500"><tr><th class="px-3 py-2 text-left">Tgl</th><th class="px-3 py-2 text-left">Karyawan</th><th class="px-3 py-2 text-left">Klien</th><th class="px-3 py-2 text-right">Insentif</th><th class="px-3 py-2">Aksi</th></tr></thead>
<tbody>
@forelse($items as $it)
<tr class="border-t">
  <td class="px-3 py-2.5 text-xs">{{ $it->tanggal->format('d/m/y') }}</td>
  <td class="px-3 py-2 font-medium">{{ $it->employee->nama }}</td>
  <td class="px-3 py-2"><div class="font-medium">{{ $it->nama_klien }}</div><div class="text-xs text-slate-500">{{ Str::limit($it->alamat_klien,40) }}</div></td>
  <td class="px-3 py-2 text-right font-bold text-emerald-600">Rp {{ number_format($it->nominal_insentif,0,',','.') }}</td>
  <td class="px-3 py-2"><div class="flex items-center justify-center gap-1.5"><a href="{{ route('acquisitions.edit',$it) }}" title="Edit Klien Baru" aria-label="Edit Klien Baru {{ $it->nama_klien }}" class="grid h-8 w-8 place-items-center rounded-lg bg-amber-50 text-amber-600 ring-1 ring-amber-100 transition hover:bg-amber-100 hover:text-amber-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-1"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"/></svg></a><form method="POST" action="{{ route('acquisitions.destroy',$it) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" title="Hapus Klien Baru" aria-label="Hapus Klien Baru {{ $it->nama_klien }}" class="grid h-8 w-8 place-items-center rounded-lg bg-rose-50 text-rose-600 ring-1 ring-rose-100 transition hover:bg-rose-100 hover:text-rose-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500 focus-visible:ring-offset-1"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg></button></form></div></td>
</tr>
@empty<tr><td colspan="5" class="px-3 py-8 text-center text-slate-400">Belum ada klien baru tercatat</td></tr>@endforelse
</tbody>
</table>
</div>
<div class="p-3 border-t">{{ $items->links() }}</div>
</div>
@endsection
