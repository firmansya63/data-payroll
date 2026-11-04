@extends('layouts.app')
@section('title','Edit Karyawan')
@section('content')

<div class="relative">
  <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
    <div class="absolute -left-16 -top-20 h-72 w-72 rounded-full bg-blue-300/40 blur-3xl"></div>
    <div class="absolute -right-10 top-10 h-80 w-80 rounded-full bg-blue-300/30 blur-3xl"></div>
  </div>

  <div class="relative z-10">
    <div class="vch-in mb-3 flex flex-wrap items-center justify-between gap-3">
      <div class="flex items-center gap-3">
        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 text-white shadow-lg shadow-amber-500/30"><i class="fa-solid fa-pen-to-square" aria-hidden="true"></i></span>
        <div class="min-w-0">
          <h1 class="text-xl font-extrabold tracking-tight text-slate-800">Edit Karyawan</h1>
          <p class="text-[11px] text-slate-500">Perbarui data {{ $employee->nama }}.</p>
        </div>
      </div>
      <a href="{{ route('employees.index') }}" class="inline-flex items-center gap-1 rounded-xl bg-white px-3 py-2 text-xs font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-blue-50 hover:text-blue-600"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Kembali</a>
    </div>

    <form method="POST" action="{{ route('employees.update',$employee) }}" class="vch-in max-w-2xl space-y-3 rounded-3xl bg-white/80 p-4 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(37,99,235,.45)] backdrop-blur-xl md:p-5" style="animation-delay:.05s">
      @csrf @method('PUT')
      <div class="grid gap-3 md:grid-cols-2">
        <label class="block text-sm font-medium text-slate-600">Nama <span class="text-rose-500">*</span>
          <input name="nama" value="{{ old('nama',$employee->nama) }}" required autocomplete="name" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
        </label>
        <label class="block text-sm font-medium text-slate-600">Jabatan <span class="text-rose-500">*</span>
          <select name="jabatan" required class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
            <option value="teknisi" {{ old('jabatan',$employee->jabatan)=='teknisi'?'selected':'' }}>Teknisi</option>
            <option value="marketing" {{ old('jabatan',$employee->jabatan)=='marketing'?'selected':'' }}>Marketing</option>
            <option value="admin" {{ old('jabatan',$employee->jabatan)=='admin'?'selected':'' }}>Admin</option>
            <option value="lainnya" {{ old('jabatan',$employee->jabatan)=='lainnya'?'selected':'' }}>Lainnya</option>
          </select>
        </label>
        <label class="block text-sm font-medium text-slate-600">Gaji Pokok (Rp) <span class="text-rose-500">*</span>
          <input type="number" name="gaji_pokok" value="{{ old('gaji_pokok',(float) $employee->gaji_pokok) }}" required min="0" step="1000" inputmode="numeric" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm tabular-nums text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
        </label>
        <label class="block text-sm font-medium text-slate-600">Bonus per Hadir (Rp)
          <input type="number" name="bonus_per_hadir" value="{{ old('bonus_per_hadir',(float) $employee->bonus_per_hadir) }}" min="0" step="1000" inputmode="numeric" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm tabular-nums text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
        </label>
        <label class="block text-sm font-medium text-slate-600 md:col-span-2">No HP
          <input name="no_hp" value="{{ old('no_hp',$employee->no_hp) }}" inputmode="tel" autocomplete="tel" placeholder="08xxxxxxxxxx" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
        </label>
        <label class="block text-sm font-medium text-slate-600 md:col-span-2">Alamat
          <textarea name="alamat" rows="2" placeholder="Opsional" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">{{ old('alamat',$employee->alamat) }}</textarea>
        </label>
      </div>

      <label for="is_active" class="flex cursor-pointer select-none items-center justify-between gap-3 rounded-2xl bg-slate-50/80 px-3.5 py-3 ring-1 ring-slate-200">
        <span class="min-w-0">
          <span class="block text-sm font-medium text-slate-700">Status karyawan</span>
          <span class="block text-[11px] text-slate-400">Nonaktifkan jika karyawan sudah tidak bekerja.</span>
        </span>
        <span class="flex shrink-0 items-center gap-2.5">
          <input id="is_active" type="checkbox" name="is_active" value="1" class="peer sr-only" {{ old('is_active',$employee->is_active) ? 'checked' : '' }}>
          <span class="text-[11px] font-semibold text-slate-500 peer-checked:hidden">Nonaktif</span>
          <span class="hidden text-[11px] font-semibold text-emerald-600 peer-checked:inline">Aktif</span>
          <span aria-hidden="true" class="relative h-6 w-11 shrink-0 rounded-full bg-slate-300 ring-1 ring-inset ring-slate-300/70 transition after:absolute after:left-0.5 after:top-0.5 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-transform after:content-[''] peer-checked:bg-blue-600 peer-checked:ring-transparent peer-checked:after:translate-x-5 peer-focus-visible:ring-2 peer-focus-visible:ring-blue-600 peer-focus-visible:ring-offset-2"></span>
        </span>
      </label>

      <div class="flex flex-wrap items-center justify-end gap-2 border-t border-slate-100 pt-3">
        <a href="{{ route('employees.index') }}" class="inline-flex items-center rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-slate-50">Batal</a>
        <button class="inline-flex items-center gap-1.5 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-600/25 transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2"><i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Update</button>
      </div>
    </form>
  </div>
</div>
@endsection
