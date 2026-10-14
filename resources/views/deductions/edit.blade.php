@extends('layouts.app')
@section('title','Edit Kasbon')
@section('content')
<h1 class="text-lg font-bold mb-4">Edit Kasbon / Potongan</h1>
<form method="POST" action="{{ route('deductions.update',$deduction) }}" class="bg-white p-4 rounded-2xl shadow-sm border space-y-3 max-w-lg">
@csrf @method('PUT')
<label class="block text-sm">Karyawan*<select name="employee_id" required class="w-full mt-1 border rounded-xl px-3 py-2 text-sm">@foreach($employees as $e)<option value="{{ $e->id }}" {{ old('employee_id',$deduction->employee_id)==$e->id?'selected':'' }}>{{ $e->nama }}</option>@endforeach</select></label>
<label class="block text-sm">Tanggal*<input type="date" name="tanggal" value="{{ old('tanggal',$deduction->tanggal->format('Y-m-d')) }}" required class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<label class="block text-sm">Nominal (Rp)*<input type="number" name="nominal" value="{{ old('nominal',$deduction->nominal) }}" required class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<label class="block text-sm">Keterangan<input name="keterangan" value="{{ old('keterangan',$deduction->keterangan) }}" class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<label class="block text-sm">Status<select name="status" class="w-full mt-1 border rounded-xl px-3 py-2 text-sm"><option value="belum_dipotong" {{ $deduction->status=='belum_dipotong'?'selected':'' }}>Belum Dipotong</option><option value="sudah_dipotong" {{ $deduction->status=='sudah_dipotong'?'selected':'' }}>Sudah Dipotong</option></select></label>
<div class="flex gap-2"><button class="bg-amber-500 text-white px-6 py-2.5 rounded-xl font-semibold">Update</button><a href="{{ route('deductions.index') }}" class="px-6 py-2.5 border rounded-xl">Batal</a></div>
</form>
@endsection
