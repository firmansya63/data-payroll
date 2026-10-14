@extends('layouts.app')
@section('title','Catat Klien Baru')
@section('content')
<h1 class="text-lg font-bold mb-4">Catat Klien Baru (Insentif)</h1>
<p class="text-sm text-slate-500 mb-3">Hanya dari sini karyawan dapat insentif. Bukan dari penjualan voucher.</p>
<form method="POST" action="{{ route('acquisitions.store') }}" class="bg-white p-4 rounded-2xl shadow-sm border space-y-3 max-w-lg">
@csrf
<label class="block text-sm">Karyawan* <select name="employee_id" required class="w-full mt-1 border rounded-xl px-3 py-2 text-sm"><option value="">-- Pilih Karyawan --</option>@foreach($employees as $e)<option value="{{ $e->id }}" {{ old('employee_id')==$e->id?'selected':'' }}>{{ $e->nama }} ({{ $e->jabatan }})</option>@endforeach</select></label>
<label class="block text-sm">Nama Klien*<input name="nama_klien" value="{{ old('nama_klien') }}" required class="w-full mt-1 border rounded-xl px-3 py-2" placeholder="Budi - RT 05"></label>
<label class="block text-sm">Alamat Klien<textarea name="alamat_klien" rows="2" class="w-full mt-1 border rounded-xl px-3 py-2" placeholder="Dusun ...">{{ old('alamat_klien') }}</textarea></label>
<label class="block text-sm">Tanggal Pasang*<input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<label class="block text-sm">Nominal Insentif (Rp)*<input type="number" name="nominal_insentif" value="{{ old('nominal_insentif',50000) }}" required min="0" class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<label class="block text-sm">Keterangan<textarea name="keterangan" rows="2" class="w-full mt-1 border rounded-xl px-3 py-2">{{ old('keterangan') }}</textarea></label>
<div class="flex gap-2"><button class="bg-emerald-600 text-white px-6 py-2.5 rounded-xl font-semibold">Simpan</button><a href="{{ route('acquisitions.index') }}" class="px-6 py-2.5 border rounded-xl">Batal</a></div>
</form>
@endsection
