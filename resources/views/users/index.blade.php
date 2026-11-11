@extends('layouts.app')
@section('title', 'Manajemen User')
@section('content')
<div class="relative">
  <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
    <div class="absolute -left-16 -top-20 h-72 w-72 rounded-full bg-blue-300/40 blur-3xl"></div>
    <div class="absolute -right-10 top-10 h-80 w-80 rounded-full bg-indigo-300/30 blur-3xl"></div>
  </div>

  <div class="relative z-10">
    <section class="flex flex-wrap items-center justify-between gap-4 rounded-3xl bg-blue-600 p-5 text-white shadow-[0_18px_45px_-18px_rgba(37,99,235,.65)] md:p-6">
      <div>
        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-white/70">Pengaturan Akses</p>
        <h1 class="mt-1 text-2xl font-extrabold tracking-tight md:text-3xl"><i class="fa-solid fa-users-gear mr-2 text-white/80"></i>Manajemen User</h1>
        <p class="mt-1 text-xs text-white/75 md:text-sm">Atur akun admin dan akun perangkat scanner absensi.</p>
      </div>
      <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-white/15 px-4 py-2.5 text-sm font-semibold ring-1 ring-white/25 transition hover:bg-white/25"><i class="fa-solid fa-user-plus"></i> Tambah User</a>
    </section>

    @if(session('ok'))
      <div class="mt-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('ok') }}</div>
    @endif
    @if($errors->has('user'))
      <div class="mt-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first('user') }}</div>
    @endif

    <div class="mt-4 overflow-hidden rounded-3xl bg-white/90 ring-1 ring-slate-200 shadow-[0_10px_30px_-18px_rgba(37,99,235,.45)]">
      <div class="overflow-x-auto">
        <table class="w-full min-w-[680px] text-left">
          <thead class="bg-slate-50 text-[11px] font-bold uppercase tracking-wide text-slate-500">
            <tr><th class="px-5 py-3">User</th><th class="px-4 py-3">Role</th><th class="px-4 py-3">Dibuat</th><th class="px-5 py-3 text-right">Aksi</th></tr>
          </thead>
          <tbody class="divide-y divide-slate-100 text-sm">
            @forelse($users as $user)
              <tr class="hover:bg-blue-50/40">
                <td class="px-5 py-4"><p class="font-bold text-slate-800">{{ $user->name }}</p><p class="mt-0.5 text-xs text-slate-500">{{ $user->email }}</p></td>
                <td class="px-4 py-4">
                  @if($user->isAdmin())
                    <span class="rounded-full bg-blue-100 px-2.5 py-1 text-[11px] font-bold text-blue-700">Admin</span>
                  @else
                    <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-bold text-emerald-700">Absensi Saja</span>
                  @endif
                </td>
                <td class="px-4 py-4 text-xs text-slate-500">{{ $user->created_at?->translatedFormat('d M Y') }}</td>
                <td class="px-5 py-4"><div class="flex justify-end gap-2">
                  <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center gap-1.5 rounded-xl bg-amber-50 px-3 py-2 text-xs font-bold text-amber-700 ring-1 ring-amber-100 transition hover:bg-amber-100"><i class="fa-solid fa-pen"></i> Edit</a>
                  @if($user->id !== auth()->id())
                    <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user {{ addslashes($user->name) }}?')">@csrf @method('DELETE')
                      <button class="inline-flex items-center gap-1.5 rounded-xl bg-rose-50 px-3 py-2 text-xs font-bold text-rose-700 ring-1 ring-rose-100 transition hover:bg-rose-100"><i class="fa-solid fa-trash"></i> Hapus</button>
                    </form>
                  @endif
                </div></td>
              </tr>
            @empty
              <tr><td colspan="4" class="px-5 py-10 text-center text-sm text-slate-500">Belum ada user.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if($users->hasPages())<div class="border-t border-slate-100 p-4">{{ $users->links() }}</div>@endif
    </div>
  </div>
</div>
@endsection
