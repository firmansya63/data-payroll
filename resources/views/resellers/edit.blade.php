@extends('layouts.app')
@section('title','Edit Reseller')
@section('content')
<h1 class="text-lg font-bold mb-4">Edit Reseller</h1>
<form method="POST" action="{{ route('resellers.update',$reseller) }}" class="bg-white p-4 rounded-2xl shadow-sm border space-y-3 max-w-lg">
@csrf @method('PUT')
<label class="block text-sm">Nama Reseller*<input name="nama" value="{{ old('nama',$reseller->nama) }}" required class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<label class="block text-sm">No HP<input name="no_hp" value="{{ old('no_hp',$reseller->no_hp) }}" class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<label class="block text-sm">Alamat<textarea name="alamat" rows="2" class="w-full mt-1 border rounded-xl px-3 py-2">{{ old('alamat',$reseller->alamat) }}</textarea></label>
<label class="block text-sm">Catatan<textarea name="catatan" rows="2" class="w-full mt-1 border rounded-xl px-3 py-2">{{ old('catatan',$reseller->catatan) }}</textarea></label>
<div class="flex gap-2"><button class="bg-sky-600 text-white px-5 py-2.5 rounded-xl font-semibold">Update</button><a href="{{ route('resellers.index') }}" class="px-5 py-2.5 border rounded-xl">Batal</a></div>
</form>
@endsection
