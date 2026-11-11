@extends('layouts.app')
@section('title', 'Tambah User')
@section('content')
<div class="mx-auto max-w-3xl">
  <div class="mb-4 flex items-center justify-between gap-3">
    <div><h1 class="text-2xl font-extrabold text-slate-800"><i class="fa-solid fa-user-plus mr-2 text-blue-600"></i>Tambah User</h1><p class="mt-1 text-sm text-slate-500">Buat akun admin atau perangkat absensi.</p></div>
    <a href="{{ route('users.index') }}" class="rounded-xl bg-white px-3 py-2 text-xs font-bold text-slate-600 ring-1 ring-slate-200 hover:bg-slate-50"><i class="fa-solid fa-arrow-left mr-1"></i>Kembali</a>
  </div>
  <form method="POST" action="{{ route('users.store') }}" class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200 md:p-6">@csrf
    @include('users._form')
    <div class="mt-5 flex justify-end gap-2 border-t border-slate-100 pt-4"><a href="{{ route('users.index') }}" class="rounded-xl px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50">Batal</a><button class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-600/25 hover:bg-blue-700"><i class="fa-solid fa-floppy-disk mr-1"></i>Simpan User</button></div>
  </form>
</div>
@endsection
