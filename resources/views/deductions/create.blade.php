@extends('layouts.app')
@section('title','Catat Kasbon')
@section('content')
<h1 class="text-lg font-bold mb-4">Catat Potongan / Kasbon</h1>
<form method="POST" action="{{ route('deductions.store') }}" class="bg-white p-4 rounded-2xl shadow-sm border space-y-3 max-w-lg">
@csrf
<label class="block text-sm">Karyawan* <select name="employee_id" required class="w-full mt-1 border rounded-xl px-3 py-2 text-sm"><option value="">-- Pilih --</option>@foreach($employees as $e)<option value="{{ $e->id }}" {{ old('employee_id')==$e->id?'selected':'' }}>{{ $e->nama }}</option>@endforeach</select></label>
<label class="block text-sm">Tanggal*<input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<label class="block text-sm">Nominal (Rp)*<input type="number" name="nominal" value="{{ old('nominal') }}" required min="0" class="w-full mt-1 border rounded-xl px-3 py-2" placeholder="200000"></label>
<label class="block text-sm">Keterangan<input name="keterangan" value="{{ old('keterangan') }}" class="w-full mt-1 border rounded-xl px-3 py-2" placeholder="Kasbon / potongan ..."></label>
<div class="flex gap-2"><button class="bg-amber-500 text-white px-6 py-2.5 rounded-xl font-semibold">Simpan</button><a href="{{ route('deductions.index') }}" class="px-6 py-2.5 border rounded-xl">Batal</a></div>
</form>
@endsection
