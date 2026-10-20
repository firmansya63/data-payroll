@extends('layouts.app')
@section('title','Bulk Presensi Harian')
@section('content')
<div class="relative">
  <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
    <div class="absolute -left-16 -top-20 h-72 w-72 rounded-full bg-indigo-300/40 blur-3xl"></div>
    <div class="absolute -right-10 top-10 h-80 w-80 rounded-full bg-fuchsia-300/30 blur-3xl"></div>
  </div>

  <div class="relative z-10">
    <div class="vch-in mb-3 flex flex-wrap items-center justify-between gap-3">
      <div class="flex items-center gap-3">
        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white shadow-lg shadow-indigo-500/30"><i class="fa-solid fa-list-check" aria-hidden="true"></i></span>
        <div class="min-w-0">
          <h1 class="text-xl font-extrabold tracking-tight text-slate-800">Bulk Presensi Harian</h1>
          <p class="text-[11px] text-slate-500">Isi kehadiran semua karyawan untuk satu tanggal. Dipakai dari klik tanggal di Kalender.</p>
        </div>
      </div>
      <a href="{{ route('presences.calendar', ['bulan'=>\Carbon\Carbon::parse($tanggal)->month,'tahun'=>\Carbon\Carbon::parse($tanggal)->year]) }}" class="inline-flex items-center gap-1 rounded-xl bg-white px-3 py-2 text-xs font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-indigo-50 hover:text-indigo-600"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Kalender</a>
    </div>

    <form method="POST" action="{{ route('presences.bulkStore') }}" class="vch-in max-w-5xl space-y-3 rounded-3xl bg-white/80 p-4 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl md:p-5" style="animation-delay:.05s">
      @csrf
      <div>
        <p class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-[0.14em] text-indigo-500"><i class="fa-solid fa-calendar-day" aria-hidden="true"></i> Tanggal Presensi</p>
        <label class="mt-1 block max-w-xs text-sm font-medium text-slate-600">Tanggal*<input type="date" name="tanggal" value="{{ $tanggal }}" required class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100"></label>
      </div>

      <div>
        <p class="flex items-center gap-1.5 pb-1 text-[10px] font-bold uppercase tracking-[0.14em] text-indigo-500"><i class="fa-solid fa-users" aria-hidden="true"></i> Daftar Karyawan</p>
        <div class="overflow-hidden rounded-2xl ring-1 ring-slate-100">
          <div class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead class="bg-slate-50/80 text-[11px] uppercase tracking-wide text-slate-400"><tr><th class="px-3 py-2 text-left font-bold">Karyawan</th><th class="w-48 px-3 py-2 text-center font-bold">Status</th></tr></thead>
              <tbody>
                @foreach($employees as $i=>$e)
                @php
                  $cur = $existing[$e->id] ?? 'hadir';
                  $meta = [
                    'hadir'=>['ring'=>'ring-emerald-200 bg-emerald-50/60','dot'=>'bg-emerald-500'],
                    'izin' =>['ring'=>'ring-amber-200 bg-amber-50/60','dot'=>'bg-amber-500'],
                    'sakit'=>['ring'=>'ring-violet-200 bg-violet-50/60','dot'=>'bg-violet-500'],
                    'alpha'=>['ring'=>'ring-rose-200 bg-rose-50/60','dot'=>'bg-rose-500'],
                  ];
                  $curMeta = $meta[$cur] ?? ['ring'=>'ring-slate-200 bg-white','dot'=>'bg-slate-400'];
                @endphp
                <tr class="border-t border-slate-100 transition hover:bg-indigo-50/40">
                  <td class="px-3 py-2.5"><div class="text-sm font-semibold text-slate-700">{{ $e->nama }}</div><div class="text-xs text-slate-400">{{ $e->jabatan }}</div></td>
                  <td class="px-3 py-2.5">
                    <input type="hidden" name="presences[{{ $i }}][employee_id]" value="{{ $e->id }}">
                    <div class="bulk-status flex items-center gap-2 rounded-xl px-2 ring-1 {{ $curMeta['ring'] }}">
                      <span class="bulk-dot h-2 w-2 shrink-0 rounded-full {{ $curMeta['dot'] }}" aria-hidden="true"></span>
                      <select name="presences[{{ $i }}][status]" class="bulk-select w-full border-0 bg-transparent py-1.5 text-sm text-slate-700 focus:outline-none focus:ring-0">
                        <option value="hadir" {{ $cur=='hadir'?'selected':'' }}>Hadir</option><option value="izin" {{ $cur=='izin'?'selected':'' }}>Izin</option><option value="sakit" {{ $cur=='sakit'?'selected':'' }}>Sakit</option><option value="alpha" {{ $cur=='alpha'?'selected':'' }}>Alpha</option>
                      </select>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="flex flex-wrap gap-2 pt-1">
        <button class="inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-500 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2"><i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Simpan Semua</button>
        <a href="{{ route('presences.calendar', ['bulan'=>\Carbon\Carbon::parse($tanggal)->month,'tahun'=>\Carbon\Carbon::parse($tanggal)->year]) }}" class="inline-flex items-center rounded-xl bg-white px-6 py-2.5 text-sm font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-slate-50">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
@push('js')
<script>
(function () {
  var meta = {
    hadir: { ring: 'ring-emerald-200 bg-emerald-50/60', dot: 'bg-emerald-500' },
    izin:  { ring: 'ring-amber-200 bg-amber-50/60',   dot: 'bg-amber-500' },
    sakit: { ring: 'ring-violet-200 bg-violet-50/60', dot: 'bg-violet-500' },
    alpha: { ring: 'ring-rose-200 bg-rose-50/60',     dot: 'bg-rose-500' }
  };
  var ringClasses = ['ring-emerald-200','ring-amber-200','ring-violet-200','ring-rose-200','ring-slate-200','bg-emerald-50/60','bg-amber-50/60','bg-violet-50/60','bg-rose-50/60','bg-white'];
  var dotClasses = ['bg-emerald-500','bg-amber-500','bg-violet-500','bg-rose-500','bg-slate-400'];
  document.querySelectorAll('.bulk-select').forEach(function (sel) {
    sel.addEventListener('change', function () {
      var wrap = sel.closest('.bulk-status');
      var dot = wrap ? wrap.querySelector('.bulk-dot') : null;
      var m = meta[sel.value];
      if (!wrap || !dot || !m) return;
      wrap.classList.remove.apply(wrap.classList, ringClasses);
      wrap.classList.add.apply(wrap.classList, m.ring.split(' '));
      dot.classList.remove.apply(dot.classList, dotClasses);
      dot.classList.add(m.dot);
    });
  });
})();
</script>
@endpush
