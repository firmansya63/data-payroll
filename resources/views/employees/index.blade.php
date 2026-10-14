@extends('layouts.app')
@section('title','Karyawan')
@section('content')
<div class="flex items-center justify-between mb-4">
  <h1 class="text-lg font-bold"><i class="fa-solid fa-users text-sky-600 mr-2"></i>Karyawan</h1>
  <a href="{{ route('employees.create') }}" class="bg-sky-600 text-white px-4 py-2 rounded-xl text-sm font-semibold"><i class="fa-solid fa-plus mr-1"></i> Tambah</a>
</div>
<form method="GET" class="mb-3 flex gap-2">
  <input name="q" value="{{ request('q') }}" placeholder="Cari nama/jabatan..." class="flex-1 border rounded-xl px-3 py-2 text-sm">
  <button class="bg-slate-800 text-white px-4 py-2 rounded-xl text-sm">Cari</button>
</form>
<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-sm">
<thead class="bg-slate-50 text-xs text-slate-500"><tr><th class="px-3 py-2 text-left">Nama</th><th class="px-3 py-2">Jabatan</th><th class="px-3 py-2 text-right">Gaji Pokok</th><th class="px-3 py-2 text-right">Bonus/Hadir</th><th class="px-3 py-2">Aktif</th><th class="px-3 py-2">Aksi</th></tr></thead>
<tbody>
@forelse($employees as $e)
<tr class="border-t">
  <td class="px-3 py-2.5"><div class="font-semibold">{{ $e->nama }}</div><div class="text-xs text-slate-500">{{ $e->no_hp ?? '-' }}</div></td>
  <td class="px-3 py-2 text-center"><span class="text-xs bg-slate-100 px-2 py-1 rounded-full">{{ $e->jabatan }}</span></td>
  <td class="px-3 py-2 text-right font-semibold">Rp {{ number_format($e->gaji_pokok,0,',','.') }}</td>
  <td class="px-3 py-2 text-right text-sky-600">Rp {{ number_format($e->bonus_per_hadir,0,',','.') }}</td>
  <td class="px-3 py-2 text-center">@if($e->is_active)<span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full text-xs">Aktif</span>@else<span class="bg-slate-200 text-slate-600 px-2 py-1 rounded-full text-xs">Nonaktif</span>@endif</td>
  <td class="px-3 py-2 flex gap-1 justify-center"><a href="{{ route('employees.edit',$e) }}" class="w-8 h-8 grid place-items-center bg-amber-100 text-amber-700 rounded-lg"><i class="fa-solid fa-pen text-xs"></i></a><form method="POST" action="{{ route('employees.destroy',$e) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="w-8 h-8 grid place-items-center bg-red-100 text-red-600 rounded-lg"><i class="fa-solid fa-trash text-xs"></i></button></form></td>
</tr>
@empty <tr><td colspan="6" class="px-3 py-8 text-center text-slate-400">Belum ada karyawan</td></tr> @endforelse
</tbody>
</table>
</div>
<div class="p-3 border-t">{{ $employees->links() }}</div>
</div>
@endsection
