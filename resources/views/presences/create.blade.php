@extends('layouts.app')
@section('title','Input Presensi')
@section('content')
<h1 class="text-lg font-bold mb-4">Input Presensi (Admin)</h1>
<form method="POST" action="{{ route('presences.store') }}" class="bg-white p-4 rounded-2xl shadow-sm border space-y-3 max-w-lg">
@csrf
<label class="block text-sm">Karyawan*
<select name="employee_id" required class="w-full mt-1 border rounded-xl px-3 py-2 text-sm">
<option value="">-- Pilih Karyawan --</option>
@foreach($employees as $e)<option value="{{ $e->id }}" {{ old('employee_id')==$e->id?'selected':'' }}>{{ $e->nama }} ({{ $e->jabatan }})</option>@endforeach
</select></label>
<label class="block text-sm">Tanggal*<input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<label class="block text-sm">Status*
<select name="status" required class="w-full mt-1 border rounded-xl px-3 py-2 text-sm">
<option value="hadir" {{ old('status')=='hadir'?'selected':'' }}>Hadir</option>
<option value="izin" {{ old('status')=='izin'?'selected':'' }}>Izin</option>
<option value="sakit" {{ old('status')=='sakit'?'selected':'' }}>Sakit</option>
<option value="alpha" {{ old('status')=='alpha'?'selected':'' }}>Alpha</option>
</select></label>
<div class="flex gap-2"><button class="bg-sky-600 text-white px-6 py-2.5 rounded-xl font-semibold">Simpan</button><a href="{{ route('presences.calendar') }}" class="px-6 py-2.5 border rounded-xl">Batal</a></div>
</form>
@endsection
