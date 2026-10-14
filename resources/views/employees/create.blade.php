@extends('layouts.app')
@section('title','Tambah Karyawan')
@section('content')
<h1 class="text-lg font-bold mb-4">Tambah Karyawan</h1>
<form method="POST" action="{{ route('employees.store') }}" class="bg-white p-4 rounded-2xl shadow-sm border space-y-3 max-w-lg">
@csrf
<label class="block text-sm">Nama*<input name="nama" value="{{ old('nama') }}" required class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<label class="block text-sm">Jabatan*
<select name="jabatan" required class="w-full mt-1 border rounded-xl px-3 py-2 text-sm">
  <option value="teknisi" {{ old('jabatan')=='teknisi'?'selected':'' }}>Teknisi</option>
  <option value="marketing" {{ old('jabatan')=='marketing'?'selected':'' }}>Marketing</option>
  <option value="admin" {{ old('jabatan')=='admin'?'selected':'' }}>Admin</option>
  <option value="lainnya" {{ old('jabatan')=='lainnya'?'selected':'' }}>Lainnya</option>
</select></label>
<div class="grid grid-cols-2 gap-3">
<label class="block text-sm">Gaji Pokok (Rp)*<input type="number" name="gaji_pokok" value="{{ old('gaji_pokok',1500000) }}" required min="0" class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<label class="block text-sm">Bonus per Hadir (Rp)<input type="number" name="bonus_per_hadir" value="{{ old('bonus_per_hadir',10000) }}" min="0" class="w-full mt-1 border rounded-xl px-3 py-2"></label>
</div>
<label class="block text-sm">No HP<input name="no_hp" value="{{ old('no_hp') }}" class="w-full mt-1 border rounded-xl px-3 py-2" placeholder="08xx"></label>
<label class="block text-sm">Alamat<textarea name="alamat" rows="2" class="w-full mt-1 border rounded-xl px-3 py-2">{{ old('alamat') }}</textarea></label>
<div class="flex gap-2"><button class="bg-sky-600 text-white px-6 py-2.5 rounded-xl font-semibold">Simpan</button><a href="{{ route('employees.index') }}" class="px-6 py-2.5 border rounded-xl">Batal</a></div>
</form>
@endsection
