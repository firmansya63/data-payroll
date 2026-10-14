@extends('layouts.app')
@section('title','Edit Karyawan')
@section('content')
<h1 class="text-lg font-bold mb-4">Edit Karyawan</h1>
<form method="POST" action="{{ route('employees.update',$employee) }}" class="bg-white p-4 rounded-2xl shadow-sm border space-y-3 max-w-lg">
@csrf @method('PUT')
<label class="block text-sm">Nama*<input name="nama" value="{{ old('nama',$employee->nama) }}" required class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<label class="block text-sm">Jabatan*
<select name="jabatan" required class="w-full mt-1 border rounded-xl px-3 py-2 text-sm">
  <option value="teknisi" {{ old('jabatan',$employee->jabatan)=='teknisi'?'selected':'' }}>Teknisi</option>
  <option value="marketing" {{ old('jabatan',$employee->jabatan)=='marketing'?'selected':'' }}>Marketing</option>
  <option value="admin" {{ old('jabatan',$employee->jabatan)=='admin'?'selected':'' }}>Admin</option>
  <option value="lainnya" {{ old('jabatan',$employee->jabatan)=='lainnya'?'selected':'' }}>Lainnya</option>
</select></label>
<div class="grid grid-cols-2 gap-3">
<label class="block text-sm">Gaji Pokok (Rp)*<input type="number" name="gaji_pokok" value="{{ old('gaji_pokok',$employee->gaji_pokok) }}" required min="0" class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<label class="block text-sm">Bonus per Hadir (Rp)<input type="number" name="bonus_per_hadir" value="{{ old('bonus_per_hadir',$employee->bonus_per_hadir) }}" min="0" class="w-full mt-1 border rounded-xl px-3 py-2"></label>
</div>
<label class="block text-sm">No HP<input name="no_hp" value="{{ old('no_hp',$employee->no_hp) }}" class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<label class="block text-sm">Alamat<textarea name="alamat" rows="2" class="w-full mt-1 border rounded-xl px-3 py-2">{{ old('alamat',$employee->alamat) }}</textarea></label>
<label class="block text-sm flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ old('is_active',$employee->is_active)?'checked':'' }}> Aktif</label>
<div class="flex gap-2"><button class="bg-sky-600 text-white px-6 py-2.5 rounded-xl font-semibold">Update</button><a href="{{ route('employees.index') }}" class="px-6 py-2.5 border rounded-xl">Batal</a></div>
</form>
@endsection
