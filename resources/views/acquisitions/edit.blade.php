@extends('layouts.app')
@section('title','Edit Klien Baru')
@section('content')
<h1 class="text-lg font-bold mb-4">Edit Klien Baru</h1>
<form method="POST" action="{{ route('acquisitions.update',$acquisition) }}" class="bg-white p-4 rounded-2xl shadow-sm border space-y-3 max-w-lg">
@csrf @method('PUT')
<label class="block text-sm">Karyawan*<select name="employee_id" required class="w-full mt-1 border rounded-xl px-3 py-2 text-sm">@foreach($employees as $e)<option value="{{ $e->id }}" {{ old('employee_id',$acquisition->employee_id)==$e->id?'selected':'' }}>{{ $e->nama }}</option>@endforeach</select></label>
<label class="block text-sm">Nama Klien*<input name="nama_klien" value="{{ old('nama_klien',$acquisition->nama_klien) }}" required class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<label class="block text-sm">Alamat Klien<textarea name="alamat_klien" rows="2" class="w-full mt-1 border rounded-xl px-3 py-2">{{ old('alamat_klien',$acquisition->alamat_klien) }}</textarea></label>
<label class="block text-sm">Tanggal*<input type="date" name="tanggal" value="{{ old('tanggal',$acquisition->tanggal->format('Y-m-d')) }}" required class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<label class="block text-sm">Nominal Insentif (Rp)*<input type="number" name="nominal_insentif" value="{{ old('nominal_insentif',$acquisition->nominal_insentif) }}" required min="0" class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<label class="block text-sm">Keterangan<textarea name="keterangan" rows="2" class="w-full mt-1 border rounded-xl px-3 py-2">{{ old('keterangan',$acquisition->keterangan) }}</textarea></label>
<div class="flex gap-2"><button class="bg-emerald-600 text-white px-6 py-2.5 rounded-xl font-semibold">Update</button><a href="{{ route('acquisitions.index') }}" class="px-6 py-2.5 border rounded-xl">Batal</a></div>
</form>
@endsection
