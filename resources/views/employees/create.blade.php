@extends('layouts.app')
@section('title','Tambah Karyawan')
@section('content')

<div class="relative">
  <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
    <div class="absolute -left-16 -top-20 h-72 w-72 rounded-full bg-indigo-300/40 blur-3xl"></div>
    <div class="absolute -right-10 top-10 h-80 w-80 rounded-full bg-fuchsia-300/30 blur-3xl"></div>
  </div>

  <div class="relative z-10">
    <div class="vch-in mb-3 flex flex-wrap items-center justify-between gap-3">
      <div class="flex items-center gap-3">
        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white shadow-lg shadow-indigo-500/30"><i class="fa-solid fa-user-plus" aria-hidden="true"></i></span>
        <div class="min-w-0">
          <h1 class="text-xl font-extrabold tracking-tight text-slate-800">Tambah Karyawan</h1>
          <p class="text-[11px] text-slate-500">Lengkapi data karyawan baru.</p>
        </div>
      </div>
      <a href="{{ route('employees.index') }}" class="inline-flex items-center gap-1 rounded-xl bg-white px-3 py-2 text-xs font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-indigo-50 hover:text-indigo-600"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Kembali</a>
    </div>

    <form method="POST" action="{{ route('employees.store') }}" class="vch-in max-w-2xl space-y-3 rounded-3xl bg-white/80 p-4 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl md:p-5" style="animation-delay:.05s">
      @csrf
      <div class="grid gap-3 md:grid-cols-2">
        <label class="block text-sm font-medium text-slate-600">Nama <span class="text-rose-500">*</span>
          <input name="nama" value="{{ old('nama') }}" required autocomplete="name" placeholder="Nama lengkap" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
        </label>
        <label class="block text-sm font-medium text-slate-600">Jabatan <span class="text-rose-500">*</span>
          <select name="jabatan" required class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
            <option value="teknisi" {{ old('jabatan')=='teknisi'?'selected':'' }}>Teknisi</option>
            <option value="marketing" {{ old('jabatan')=='marketing'?'selected':'' }}>Marketing</option>
            <option value="admin" {{ old('jabatan')=='admin'?'selected':'' }}>Admin</option>
            <option value="lainnya" {{ old('jabatan')=='lainnya'?'selected':'' }}>Lainnya</option>
          </select>
        </label>
        <label class="block text-sm font-medium text-slate-600">Gaji Pokok (Rp) <span class="text-rose-500">*</span>
          <input type="number" name="gaji_pokok" value="{{ old('gaji_pokok',1500000) }}" required min="0" step="1000" inputmode="numeric" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm tabular-nums text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
        </label>
        <label class="block text-sm font-medium text-slate-600">Bonus per Hadir (Rp)
          <input type="number" name="bonus_per_hadir" value="{{ old('bonus_per_hadir',10000) }}" min="0" step="1000" inputmode="numeric" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm tabular-nums text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
        </label>
        <label class="block text-sm font-medium text-slate-600 md:col-span-2">No HP
          <input name="no_hp" value="{{ old('no_hp') }}" inputmode="tel" autocomplete="tel" placeholder="08xxxxxxxxxx" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
        </label>
        <label class="block text-sm font-medium text-slate-600 md:col-span-2">Alamat
          <textarea name="alamat" rows="2" placeholder="Opsional" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">{{ old('alamat') }}</textarea>
        </label>
      </div>
      <div class="flex flex-wrap items-center justify-end gap-2 border-t border-slate-100 pt-3">
        <a href="{{ route('employees.index') }}" class="inline-flex items-center rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-slate-50">Batal</a>
        <button class="inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2"><i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection
