@extends('layouts.app')
@section('title','Bulk Presensi Harian')
@section('content')
<h1 class="text-lg font-bold mb-1">Bulk Presensi Harian</h1>
<p class="text-sm text-slate-500 mb-3">Isi kehadiran semua karyawan untuk satu tanggal. Dipakai dari klik tanggal di Kalender.</p>
<form method="POST" action="{{ route('presences.bulkStore') }}" class="bg-white p-4 rounded-2xl shadow-sm border space-y-3">
@csrf
<label class="block text-sm max-w-xs">Tanggal*<input type="date" name="tanggal" value="{{ $tanggal }}" required class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<div class="overflow-x-auto border rounded-xl">
<table class="w-full text-sm">
<thead class="bg-slate-50 text-xs text-slate-500"><tr><th class="px-3 py-2 text-left">Karyawan</th><th class="px-3 py-2">Status</th></tr></thead>
<tbody>
@foreach($employees as $i=>$e)
@php $cur = $existing[$e->id] ?? 'hadir'; @endphp
<tr class="border-t">
<td class="px-3 py-2"><div class="font-medium">{{ $e->nama }}</div><div class="text-xs text-slate-500">{{ $e->jabatan }}</div></td>
<td class="px-3 py-2">
  <input type="hidden" name="presences[{{ $i }}][employee_id]" value="{{ $e->id }}">
  <select name="presences[{{ $i }}][status]" class="border rounded-xl px-2 py-1.5 text-sm w-full">
    <option value="hadir" {{ $cur=='hadir'?'selected':'' }}>Hadir</option><option value="izin" {{ $cur=='izin'?'selected':'' }}>Izin</option><option value="sakit" {{ $cur=='sakit'?'selected':'' }}>Sakit</option><option value="alpha" {{ $cur=='alpha'?'selected':'' }}>Alpha</option>
  </select>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
<div class="flex gap-2"><button class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-semibold">Simpan Semua</button><a href="{{ route('presences.calendar', ['bulan'=>\Carbon\Carbon::parse($tanggal)->month,'tahun'=>\Carbon\Carbon::parse($tanggal)->year]) }}" class="px-6 py-2.5 border rounded-xl">Batal</a></div>
</form>
@endsection
