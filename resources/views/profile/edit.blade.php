@extends('layouts.app')
@section('title','Profil')
@section('content')
<div class="max-w-3xl mx-auto space-y-4">
  <div class="flex items-center gap-3">
    <a href="{{ route('dashboard') }}" class="w-9 h-9 bg-white border rounded-xl grid place-items-center text-slate-600 hover:bg-slate-50"><i class="fa-solid fa-arrow-left"></i></a>
    <div>
      <h1 class="text-lg font-bold text-slate-800">Profil Saya</h1>
      <p class="text-xs text-slate-500">Kelola nama, email, dan password akun Datanet</p>
    </div>
  </div>

  <div class="bg-gradient-to-br from-[#1b2d4a] to-[#243656] rounded-2xl p-5 text-white flex items-center gap-4 shadow-sm">
    <div class="w-14 h-14 rounded-2xl bg-white text-[#1b2d4a] grid place-items-center font-bold text-lg shrink-0">{{ strtoupper(substr($user->name,0,2)) }}</div>
    <div class="min-w-0">
      <div class="font-semibold leading-tight truncate">{{ $user->name }}</div>
      <div class="text-sm text-slate-200 truncate"><i class="fa-solid fa-envelope mr-1 text-[#f68b1e]"></i> {{ $user->email }}</div>
      <div class="text-[11px] text-slate-300 mt-1"><i class="fa-solid fa-calendar mr-1"></i> Bergabung {{ $user->created_at?->translatedFormat('d F Y') ?? '-' }} &middot; Login terakhir {{ $user->updated_at?->diffForHumans() }}</div>
    </div>
    <img src="{{ asset('logo.png') }}" alt="Datanet" class="ml-auto hidden sm:block w-10 h-10 bg-white rounded-xl p-1.5 object-contain opacity-90">
  </div>

  <div class="bg-white rounded-2xl border shadow-sm p-5 md:p-6">
    <h2 class="font-semibold text-slate-800"><i class="fa-solid fa-user-pen mr-1.5 text-[#1b2d4a]"></i> Informasi Akun</h2>
    <p class="text-xs text-slate-500 mt-1">Perbarui nama tampil & email login. Email harus unik.</p>
    <form method="POST" action="{{ route('profile.update') }}" class="mt-4 space-y-4">
      @csrf @method('PATCH')
      <div>
        <label class="text-xs font-semibold text-slate-600">Nama</label>
        <div class="mt-1 relative">
          <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"><i class="fa-solid fa-user"></i></span>
          <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full pl-9 pr-3 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-[#1b2d4a] focus:ring-2 focus:ring-[#1b2d4a]/10 outline-none text-sm">
        </div>
        @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="text-xs font-semibold text-slate-600">Email</label>
        <div class="mt-1 relative">
          <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"><i class="fa-solid fa-envelope"></i></span>
          <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full pl-9 pr-3 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-[#1b2d4a] focus:ring-2 focus:ring-[#1b2d4a]/10 outline-none text-sm">
        </div>
        @error('email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
      </div>
      <button type="submit" class="w-full md:w-auto bg-[#1b2d4a] hover:bg-[#16233a] text-white font-semibold px-6 py-3 rounded-xl transition shadow-sm"><i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Profil</button>
    </form>
  </div>

  <div class="bg-white rounded-2xl border shadow-sm p-5 md:p-6">
    <h2 class="font-semibold text-slate-800"><i class="fa-solid fa-key mr-1.5 text-[#f68b1e]"></i> Ganti Password</h2>
    <p class="text-xs text-slate-500 mt-1">Minimal 8 karakter. Harus konfirmasi password baru.</p>
    <form method="POST" action="{{ route('profile.password') }}" class="mt-4 space-y-4">
      @csrf @method('PATCH')
      <div>
        <label class="text-xs font-semibold text-slate-600">Password Saat Ini</label>
        <div class="mt-1 relative">
          <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"><i class="fa-solid fa-lock"></i></span>
          <input type="password" name="current_password" required placeholder="••••••••" class="w-full pl-9 pr-3 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-[#1b2d4a] focus:ring-2 focus:ring-[#1b2d4a]/10 outline-none text-sm">
        </div>
        @error('current_password')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
      </div>
      <div class="grid md:grid-cols-2 gap-4">
        <div>
          <label class="text-xs font-semibold text-slate-600">Password Baru</label>
          <input type="password" name="password" required placeholder="Minimal 8 karakter" class="mt-1 w-full px-3 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-[#1b2d4a] focus:ring-2 focus:ring-[#1b2d4a]/10 outline-none text-sm">
          @error('password')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="text-xs font-semibold text-slate-600">Konfirmasi Password Baru</label>
          <input type="password" name="password_confirmation" required placeholder="Ulangi password baru" class="mt-1 w-full px-3 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-[#1b2d4a] focus:ring-2 focus:ring-[#1b2d4a]/10 outline-none text-sm">
        </div>
      </div>
      <button type="submit" class="w-full md:w-auto bg-[#f68b1e] hover:bg-[#e67e17] text-white font-semibold px-6 py-3 rounded-xl transition shadow-sm"><i class="fa-solid fa-shield-halved mr-1"></i> Ubah Password</button>
    </form>
  </div>

  <p class="text-center text-[11px] text-slate-400">Akun dikelola internal Datanet &middot; Hubungi admin jika butuh reset.</p>
</div>
@endsection
