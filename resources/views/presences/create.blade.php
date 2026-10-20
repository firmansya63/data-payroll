@extends('layouts.app')
@section('title','Input Presensi')
@section('content')
<div class="relative">
  <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
    <div class="absolute -left-16 -top-20 h-72 w-72 rounded-full bg-indigo-300/40 blur-3xl"></div>
    <div class="absolute -right-10 top-10 h-80 w-80 rounded-full bg-fuchsia-300/30 blur-3xl"></div>
  </div>

  <div class="relative z-10">
    <div class="vch-in mb-3 flex flex-wrap items-center justify-between gap-3">
      <div class="flex items-center gap-3">
        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white shadow-lg shadow-indigo-500/30"><i class="fa-solid fa-clipboard-user" aria-hidden="true"></i></span>
        <div class="min-w-0">
          <h1 class="text-xl font-extrabold tracking-tight text-slate-800">Input Presensi (Admin)</h1>
          <p class="text-[11px] text-slate-500">Catat kehadiran satu karyawan untuk tanggal tertentu.</p>
        </div>
      </div>
      <a href="{{ route('presences.calendar') }}" class="inline-flex items-center gap-1 rounded-xl bg-white px-3 py-2 text-xs font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-indigo-50 hover:text-indigo-600"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Kalender</a>
    </div>

    <form method="POST" action="{{ route('presences.store') }}" class="vch-in max-w-lg space-y-3 rounded-3xl bg-white/80 p-4 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl md:p-5" style="animation-delay:.05s">
      @csrf
      <label class="block text-sm font-medium text-slate-600">Karyawan*
        <select name="employee_id" required class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
          <option value="">-- Pilih Karyawan --</option>
          @foreach($employees as $e)<option value="{{ $e->id }}" {{ old('employee_id')==$e->id?'selected':'' }}>{{ $e->nama }} ({{ $e->jabatan }})</option>@endforeach
        </select>
      </label>
      <label class="block text-sm font-medium text-slate-600">Tanggal*<input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100"></label>
      <label class="block text-sm font-medium text-slate-600">Status*
        <select name="status" required class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
          <option value="hadir" {{ old('status')=='hadir'?'selected':'' }}>Hadir</option>
          <option value="izin" {{ old('status')=='izin'?'selected':'' }}>Izin</option>
          <option value="sakit" {{ old('status')=='sakit'?'selected':'' }}>Sakit</option>
          <option value="alpha" {{ old('status')=='alpha'?'selected':'' }}>Alpha</option>
        </select>
      </label>
      <div class="flex flex-wrap gap-2 pt-1">
        <button class="inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-500 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2"><i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Simpan</button>
        <a href="{{ route('presences.calendar') }}" class="inline-flex items-center rounded-xl bg-white px-6 py-2.5 text-sm font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-slate-50">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection