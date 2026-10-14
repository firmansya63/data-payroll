@extends('layouts.app')
@section('title','Reseller')
@section('content')
<div class="flex items-center justify-between mb-4">
  <h1 class="text-lg font-bold"><i class="fa-solid fa-store text-sky-600 mr-2"></i>Reseller</h1>
  <a href="{{ route('resellers.create') }}" class="bg-sky-600 text-white px-4 py-2 rounded-xl text-sm font-semibold"><i class="fa-solid fa-plus mr-1"></i> Tambah</a>
</div>
<form method="GET" class="mb-3 flex gap-2">
  <input name="q" value="{{ request('q') }}" placeholder="Cari nama/no HP..." class="flex-1 border rounded-xl px-3 py-2 text-sm">
  <button class="bg-slate-800 text-white px-4 py-2 rounded-xl text-sm">Cari</button>
</form>
<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-sm">
<thead class="bg-slate-50 text-xs text-slate-500"><tr><th class="px-3 py-2 text-left">Nama</th><th class="px-3 py-2">Kontak</th><th class="px-3 py-2 text-right">Piutang</th><th class="px-3 py-2 text-right">Lunas</th><th class="px-3 py-2">Aksi</th></tr></thead>
<tbody>
@forelse($resellers as $r)
<tr class="border-t">
  <td class="px-3 py-2.5"><div class="font-semibold">{{ $r->nama }}</div><div class="text-xs text-slate-500">{{ Str::limit($r->alamat,40) }}</div></td>
  <td class="px-3 py-2 text-center text-xs">{{ $r->no_hp ?? '-' }}</td>
  <td class="px-3 py-2 text-right font-bold text-red-600">Rp {{ number_format($r->total_piutang,0,',','.') }}</td>
  <td class="px-3 py-2 text-right text-emerald-600">Rp {{ number_format($r->total_lunas,0,',','.') }}</td>
  <td class="px-3 py-2 flex gap-1 justify-center">
    <a href="{{ route('resellers.edit',$r) }}" class="w-8 h-8 grid place-items-center bg-amber-100 text-amber-700 rounded-lg"><i class="fa-solid fa-pen text-xs"></i></a>
    <form method="POST" action="{{ route('resellers.destroy',$r) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="w-8 h-8 grid place-items-center bg-red-100 text-red-600 rounded-lg"><i class="fa-solid fa-trash text-xs"></i></button></form>
  </td>
</tr>
@empty <tr><td colspan="5" class="px-3 py-8 text-center text-slate-400">Belum ada reseller</td></tr> @endforelse
</tbody>
</table>
</div>
<div class="p-3 border-t">{{ $resellers->links() }}</div>
</div>
@endsection
