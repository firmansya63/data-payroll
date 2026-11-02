@extends('layouts.app')
@section('title','Karyawan')
@section('content')

<div class="relative">
  <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
    <div class="absolute -left-16 -top-20 h-72 w-72 rounded-full bg-indigo-300/40 blur-3xl"></div>
    <div class="absolute -right-10 top-10 h-80 w-80 rounded-full bg-fuchsia-300/30 blur-3xl"></div>
  </div>

  <div class="relative z-10">
    {{-- HERO --}}
    <section class="vch-in relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-violet-600 to-fuchsia-500 p-5 text-white shadow-[0_18px_45px_-18px_rgba(99,102,241,.65)] md:p-6">
      <div class="pointer-events-none absolute -right-12 -top-20 h-56 w-56 rounded-full bg-white/15 blur-2xl" aria-hidden="true"></div>
      <div class="pointer-events-none absolute -bottom-24 -left-12 h-64 w-64 rounded-full bg-fuchsia-300/25 blur-3xl" aria-hidden="true"></div>
      <div class="relative flex flex-wrap items-start justify-between gap-4">
        <div class="min-w-0">
          <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-white/70">SDM</p>
          <h1 class="mt-1 flex items-center gap-2 text-2xl font-extrabold tracking-tight md:text-3xl"><i class="fa-solid fa-users text-white/80" aria-hidden="true"></i> Karyawan</h1>
          <p class="mt-1 text-xs text-white/75 md:text-sm">Kelola data karyawan, gaji pokok, dan bonus kehadiran.</p>
        </div>
        <a href="{{ route('employees.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-white/15 px-4 py-2.5 text-sm font-semibold ring-1 ring-white/25 backdrop-blur transition hover:bg-white/25 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/60"><i class="fa-solid fa-plus" aria-hidden="true"></i> Tambah Karyawan</a>
      </div>
    </section>

    @php
      $aktifParam = request('aktif');
      $hasFilter = request()->filled('q') || request()->filled('aktif');
      $qs = fn(array $extra) => array_filter($extra, fn($v) => $v !== null && $v !== '');
      $pill = 'inline-flex items-center justify-center rounded-xl px-3 py-2 text-xs font-semibold transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2';
      $pillOn = 'bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-500 text-white shadow-lg shadow-indigo-500/25';
      $pillOff = 'bg-white text-slate-600 ring-1 ring-slate-200 hover:bg-indigo-50 hover:text-indigo-600';
    @endphp

    {{-- PENCARIAN & FILTER --}}
    <form method="GET" class="vch-in mt-3 rounded-3xl bg-white/80 p-3 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl md:p-4" style="animation-delay:.05s">
      @if(request()->filled('aktif'))<input type="hidden" name="aktif" value="{{ $aktifParam }}">@endif
      <div class="flex flex-col gap-2 md:flex-row md:items-center">
        <div class="relative min-w-0 flex-1">
          <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400" aria-hidden="true"></i>
          <input name="q" value="{{ request('q') }}" placeholder="Cari nama / jabatan..." aria-label="Cari karyawan" class="w-full rounded-xl border border-slate-200 bg-white py-2 pl-9 pr-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
        </div>
        <div class="flex gap-2">
          <button class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-xl bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2 md:flex-none"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i> Cari</button>
          @if($hasFilter)
          <a href="{{ route('employees.index') }}" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-white px-3 py-2 text-sm font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-indigo-50 hover:text-indigo-600"><i class="fa-solid fa-rotate-left" aria-hidden="true"></i> Reset</a>
          @endif
        </div>
      </div>

      <div class="mt-2.5 flex flex-wrap items-center gap-1.5 border-t border-slate-100 pt-2.5">
        <span class="mr-1 text-[11px] font-semibold uppercase tracking-wide text-slate-400">Status</span>
        <a href="{{ route('employees.index', $qs(['q' => request('q')])) }}" class="{{ $pill }} {{ $aktifParam === null || $aktifParam === '' ? $pillOn : $pillOff }}" @if($aktifParam === null || $aktifParam === '') aria-current="page" @endif>Semua</a>
        <a href="{{ route('employees.index', $qs(['q' => request('q'), 'aktif' => 1])) }}" class="{{ $pill }} {{ (string) $aktifParam === '1' ? $pillOn : $pillOff }}" @if((string) $aktifParam === '1') aria-current="page" @endif>Aktif</a>
        <a href="{{ route('employees.index', $qs(['q' => request('q'), 'aktif' => 0])) }}" class="{{ $pill }} {{ (string) $aktifParam === '0' ? $pillOn : $pillOff }}" @if((string) $aktifParam === '0') aria-current="page" @endif>Nonaktif</a>
      </div>
    </form>


    {{-- DAFTAR --}}
    <div class="vch-in mt-3 overflow-hidden rounded-3xl bg-white/80 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl" style="animation-delay:.1s">
      <div class="overflow-x-auto">
        <table class="w-full min-w-[720px] text-sm">
          <thead class="bg-slate-50/80 text-[11px] uppercase tracking-wide text-slate-400">
            <tr>
              <th class="px-3 py-2.5 text-left font-semibold">Karyawan</th>
              <th class="px-3 py-2.5 text-center font-semibold">Jabatan</th>
              <th class="px-3 py-2.5 text-right font-semibold">Gaji Pokok</th>
              <th class="px-3 py-2.5 text-right font-semibold">Bonus/Hadir</th>
              <th class="px-3 py-2.5 text-center font-semibold">Status</th>
              <th class="px-3 py-2.5 text-center font-semibold">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
          @php
            $jabatanStyle = [
              'teknisi' => 'bg-indigo-50 text-indigo-600 ring-indigo-100',
              'marketing' => 'bg-fuchsia-50 text-fuchsia-600 ring-fuchsia-100',
              'admin' => 'bg-violet-50 text-violet-600 ring-violet-100',
            ];
          @endphp
          @forelse($employees as $e)
            <tr class="transition-colors hover:bg-indigo-50/40">
              <td class="px-3 py-2.5">
                <div class="flex items-center gap-2.5">
                  <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-[11px] font-bold uppercase text-white shadow-lg shadow-indigo-500/30">{{ Str::upper(Str::substr($e->nama, 0, 2)) }}</span>
                  <div class="min-w-0">
                    <div class="truncate font-semibold text-slate-800">{{ $e->nama }}</div>
                    <div class="truncate text-[11px] text-slate-400">{{ $e->no_hp ?: 'No HP belum diisi' }}</div>
                  </div>
                </div>
              </td>
              <td class="px-3 py-2.5 text-center">
                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-semibold capitalize ring-1 {{ $jabatanStyle[$e->jabatan] ?? 'bg-slate-50 text-slate-500 ring-slate-200' }}">{{ $e->jabatan }}</span>
              </td>
              <td class="px-3 py-2.5 text-right font-bold tabular-nums text-slate-800">Rp {{ number_format((float) $e->gaji_pokok, 0, ',', '.') }}</td>
              <td class="px-3 py-2.5 text-right font-semibold tabular-nums text-fuchsia-600">Rp {{ number_format((float) $e->bonus_per_hadir, 0, ',', '.') }}</td>
              <td class="px-3 py-2.5 text-center">
                @if($e->is_active)
                  <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-600 ring-1 ring-emerald-100"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span>Aktif</span>
                @else
                  <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-50 px-2.5 py-1 text-[11px] font-semibold text-slate-500 ring-1 ring-slate-200"><span class="h-1.5 w-1.5 rounded-full bg-slate-400" aria-hidden="true"></span>Nonaktif</span>
                @endif
              </td>
              <td class="px-3 py-2.5">
                <div class="flex items-center justify-center gap-1">
                  @if($e->is_active)
                    <a href="{{ route('presences.create', ['employee_id' => $e->id]) }}" class="grid h-8 w-8 place-items-center rounded-lg bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100 transition hover:bg-indigo-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-1" title="Absen" aria-label="Absen {{ $e->nama }}"><i class="fa-solid fa-clipboard-user text-xs" aria-hidden="true"></i></a>
                  @endif
                  <a href="{{ route('employees.edit', $e) }}" class="grid h-8 w-8 place-items-center rounded-lg bg-amber-50 text-amber-600 ring-1 ring-amber-100 transition hover:bg-amber-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-1" title="Edit" aria-label="Edit {{ $e->nama }}"><i class="fa-solid fa-pen text-xs" aria-hidden="true"></i></a>
                  <form method="POST" action="{{ route('employees.destroy', $e) }}" onsubmit="return confirm('Hapus karyawan ini?')">@csrf @method('DELETE')
                    <button class="grid h-8 w-8 place-items-center rounded-lg bg-rose-50 text-rose-600 ring-1 ring-rose-100 transition hover:bg-rose-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-400 focus-visible:ring-offset-1" title="Hapus" aria-label="Hapus {{ $e->nama }}"><i class="fa-solid fa-trash text-xs" aria-hidden="true"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-3 py-10 text-center">
                <span class="mx-auto mb-2 grid h-11 w-11 place-items-center rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white shadow-lg shadow-indigo-500/30" aria-hidden="true"><i class="fa-solid fa-users"></i></span>
                <p class="text-sm font-semibold text-slate-600">Belum ada karyawan</p>
                <p class="mt-0.5 text-[11px] text-slate-400">{{ $hasFilter ? 'Tidak ada karyawan yang cocok dengan pencarian / filter saat ini.' : 'Tambahkan karyawan untuk mulai mencatat presensi dan payroll.' }}</p>
              </td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
      @if($employees->hasPages())
      <div class="border-t border-slate-100 p-3">{{ $employees->links() }}</div>
      @endif
    </div>
  </div>
</div>
@endsection
