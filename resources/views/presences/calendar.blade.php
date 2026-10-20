@extends('layouts.app')
@section('title','Kalender Presensi')
@section('content')
<div class="relative">
  <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
    <div class="absolute -left-16 -top-20 h-72 w-72 rounded-full bg-indigo-300/40 blur-3xl"></div>
    <div class="absolute -right-10 top-10 h-80 w-80 rounded-full bg-fuchsia-300/30 blur-3xl"></div>
  </div>

  <div class="relative z-10">
    <div class="vch-in mb-3 overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-violet-600 to-fuchsia-500 px-4 py-4 text-white shadow-[0_18px_45px_-18px_rgba(99,102,241,.65)] md:px-5">
      <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-3">
          <span class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-white/15 ring-1 ring-white/25 backdrop-blur"><i class="fa-solid fa-calendar-check text-lg" aria-hidden="true"></i></span>
          <div class="min-w-0">
            <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-white/60">Kehadiran</p>
            <h1 class="text-xl font-extrabold tracking-tight">Kalender Presensi</h1>
            <p class="text-[11px] text-white/70">Pantau kehadiran harian, rekap per karyawan, dan input bulk sekali klik.</p>
          </div>
        </div>
        <a href="{{ route('presences.bulk') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-white/15 px-4 py-2 text-sm font-semibold text-white ring-1 ring-white/30 backdrop-blur transition hover:bg-white/25"><i class="fa-solid fa-list-check" aria-hidden="true"></i> Bulk Harian</a>
      </div>
    </div>

    <form method="GET" class="vch-in mb-3 space-y-2 rounded-3xl bg-white/80 p-3 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl md:p-4" style="animation-delay:.05s">
      <div class="grid grid-cols-1 gap-2 md:grid-cols-4">
        <label class="block text-xs font-semibold text-slate-600">Karyawan <span class="font-normal text-slate-400">kosong = rekap semua</span>
          <select name="employee_id" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
            <option value="">-- Semua Karyawan (Rekap) --</option>
            @foreach($employees as $e)
              <option value="{{ $e->id }}" {{ (string)$employeeId === (string)$e->id ? 'selected' : '' }}>{{ $e->nama }} - {{ $e->jabatan }}</option>
            @endforeach
          </select>
        </label>
        <label class="block text-xs font-semibold text-slate-600">Bulan
          <select name="bulan" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">@for($m=1;$m<=12;$m++)<option value="{{ $m }}" {{ $bulan==$m?'selected':'' }}>{{ DateTime::createFromFormat('!m',$m)->format('F') }}</option>@endfor</select>
        </label>
        <label class="block text-xs font-semibold text-slate-600">Tahun
          <select name="tahun" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">@for($y=now()->year-1;$y<=now()->year+1;$y++)<option value="{{ $y }}" {{ $tahun==$y?'selected':'' }}>{{ $y }}</option>@endfor</select>
        </label>
        <div class="flex items-end gap-2">
          <button class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-xl bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-500 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2"><i class="fa-solid fa-eye" aria-hidden="true"></i> Tampilkan</button>
          @if($selectedEmployee)
            <a href="{{ route('presences.calendar', ['bulan'=>$bulan,'tahun'=>$tahun]) }}" class="inline-flex items-center gap-1 rounded-xl bg-white px-3 py-2.5 text-xs font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-slate-50"><i class="fa-solid fa-rotate-left text-[10px]" aria-hidden="true"></i> Reset</a>
          @endif
        </div>
      </div>
      <p class="text-[11px] text-slate-400"><i class="fa-solid fa-circle-info mr-1" aria-hidden="true"></i> Kosongkan karyawan untuk <b class="text-slate-600">rekap semua</b> periode ini; pilih satu untuk kalender per orang. Klik tanggal &rarr; Bulk Harian.</p>
    </form>
    @if(!$selectedEmployee)
      <div class="vch-in overflow-hidden rounded-3xl bg-white/80 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl" style="animation-delay:.1s">
        <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 p-3 md:p-4">
          <div class="flex items-center gap-2">
            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white shadow-sm shadow-indigo-500/30"><i class="fa-solid fa-users text-xs" aria-hidden="true"></i></span>
            <div class="min-w-0">
              <h3 class="text-sm font-bold text-slate-800">Rekap {{ \Carbon\Carbon::create($tahun,$bulan,1)->translatedFormat('F Y') }}</h3>
              <p class="text-[11px] text-slate-400">Semua Karyawan &middot; klik kartu/nama &rarr; kalender per orang</p>
            </div>
          </div>
          <span class="rounded-full bg-indigo-50 px-3 py-1.5 text-[11px] font-semibold text-indigo-600 ring-1 ring-indigo-100">{{ $employees->count() }} karyawan aktif</span>
        </div>
        <div class="p-3 md:p-4">
          @if(isset($rekapSemua) && $rekapSemua->count())
          <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3">
            @foreach($rekapSemua as $row)
              @php $e=$row['employee']; $tot=$row['hadir']+$row['izin']+$row['sakit']+$row['alpha']; @endphp
              <a href="{{ route('presences.calendar', ['employee_id'=>$e->id,'bulan'=>$bulan,'tahun'=>$tahun]) }}" class="group rounded-2xl bg-white p-3 text-left ring-1 ring-slate-100 transition hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] hover:ring-indigo-200">
                <div class="flex items-start justify-between gap-2">
                  <div class="min-w-0">
                    <div class="truncate text-sm font-semibold text-slate-800 group-hover:text-indigo-600">{{ $e->nama }}</div>
                    <div class="truncate text-xs text-slate-400">{{ $e->jabatan }}</div>
                  </div>
                  <span class="grid h-7 w-7 shrink-0 place-items-center rounded-lg bg-indigo-50 text-indigo-500 ring-1 ring-indigo-100 transition group-hover:bg-gradient-to-br group-hover:from-indigo-500 group-hover:to-violet-600 group-hover:text-white"><i class="fa-solid fa-arrow-right text-[10px]" aria-hidden="true"></i></span>
                </div>
                <div class="mt-2 grid grid-cols-4 gap-1 text-center">
                  <div><div class="text-sm font-extrabold tabular-nums text-emerald-600">{{ $row['hadir'] }}</div><div class="text-[10px] text-slate-400">Hadir</div></div>
                  <div><div class="text-sm font-extrabold tabular-nums text-amber-600">{{ $row['izin'] }}</div><div class="text-[10px] text-slate-400">Izin</div></div>
                  <div><div class="text-sm font-extrabold tabular-nums text-violet-600">{{ $row['sakit'] }}</div><div class="text-[10px] text-slate-400">Sakit</div></div>
                  <div><div class="text-sm font-extrabold tabular-nums text-rose-600">{{ $row['alpha'] }}</div><div class="text-[10px] text-slate-400">Alpha</div></div>
                </div>
                <div class="mt-2 text-[11px] text-slate-400">Terisi: <b class="text-slate-700">{{ $tot }}</b> / {{ $daysInMonth }} hari &middot; <span class="font-semibold text-indigo-600">lihat kalender &rarr;</span></div>
              </a>
            @endforeach
          </div>
          @else
          <div class="flex flex-col items-center gap-2 py-8 text-center">
            <span class="grid h-12 w-12 place-items-center rounded-2xl bg-indigo-50 text-indigo-400 ring-1 ring-indigo-100"><i class="fa-solid fa-users" aria-hidden="true"></i></span>
            <p class="text-sm font-semibold text-slate-500">Belum ada karyawan aktif.</p>
          </div>
          @endif
          @if($employees->count())
          <div class="mt-3 flex flex-wrap justify-center gap-2 border-t border-slate-100 pt-3">
            @foreach($employees->take(10) as $e)
              <a href="{{ route('presences.calendar', ['employee_id'=>$e->id,'bulan'=>$bulan,'tahun'=>$tahun]) }}" class="rounded-full bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-gradient-to-r hover:from-indigo-600 hover:to-violet-600 hover:text-white hover:ring-indigo-500">{{ $e->nama }}</a>
            @endforeach
          </div>
          @endif
          <p class="mt-3 text-center text-[11px] text-slate-400"><i class="fa-solid fa-circle-info mr-1" aria-hidden="true"></i> Rekap hanya di Kalender (tabel tanpa rekap). Klik kartu/nama untuk kalender per orang &mdash; Sab/Ming = LIBUR, klik tanggal &rarr; Bulk.</p>
        </div>
      </div>
    @else
      <div class="vch-in mb-2 flex flex-wrap items-center gap-2" style="animation-delay:.1s">
        <a href="{{ route('presences.calendar', ['bulan'=>$bulan,'tahun'=>$tahun]) }}" class="inline-flex items-center gap-1 rounded-xl bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-indigo-50 hover:text-indigo-600"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Rekap Semua</a>
        <span class="rounded-full bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-600 ring-1 ring-indigo-100">{{ $selectedEmployee->nama }} &mdash; {{ $selectedEmployee->jabatan }}</span>
      </div>
      @php
        $monthLabel = $first->translatedFormat('F Y');
        $todayStr = now()->format('Y-m-d');
        $cfg = [
          'hadir'=>['label'=>'HADIR','bg'=>'bg-emerald-50','bd'=>'border-emerald-200','badge'=>'bg-emerald-500 text-white'],
          'izin'=> ['label'=>'IZIN','bg'=>'bg-amber-50','bd'=>'border-amber-200','badge'=>'bg-amber-500 text-white'],
          'sakit'=>['label'=>'SAKIT','bg'=>'bg-violet-50','bd'=>'border-violet-200','badge'=>'bg-violet-500 text-white'],
          'alpha'=>['label'=>'ALPHA','bg'=>'bg-rose-50','bd'=>'border-rose-200','badge'=>'bg-rose-500 text-white'],
        ];
      @endphp
      <div class="vch-in mb-3 flex items-center justify-between gap-2" style="animation-delay:.15s">
        <a href="{{ route('presences.calendar', ['employee_id'=>$selectedEmployee->id,'bulan'=>$prev->month,'tahun'=>$prev->year]) }}" class="grid h-9 w-9 place-items-center rounded-xl bg-white text-slate-500 ring-1 ring-slate-200 transition hover:bg-indigo-50 hover:text-indigo-600" title="Bulan sebelumnya"><i class="fa-solid fa-chevron-left text-xs" aria-hidden="true"></i></a>
        <div class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2 ring-1 ring-slate-200 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)]">
          <span class="grid h-8 w-8 place-items-center rounded-lg bg-gradient-to-br from-indigo-500 to-violet-600 text-xs text-white shadow-sm shadow-indigo-500/30"><i class="fa-solid fa-calendar-days" aria-hidden="true"></i></span>
          <div class="text-left">
            <div class="text-sm font-bold leading-none text-slate-800">{{ $monthLabel }}</div>
            <div class="mt-1 text-[11px] leading-none text-slate-500">{{ $selectedEmployee->nama }} - {{ $selectedEmployee->jabatan }}</div>
          </div>
        </div>
        <a href="{{ route('presences.calendar', ['employee_id'=>$selectedEmployee->id,'bulan'=>$next->month,'tahun'=>$next->year]) }}" class="grid h-9 w-9 place-items-center rounded-xl bg-white text-slate-500 ring-1 ring-slate-200 transition hover:bg-indigo-50 hover:text-indigo-600" title="Bulan berikutnya"><i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i></a>
      </div>
      <div class="vch-in mb-3 grid grid-cols-2 gap-2 md:grid-cols-5" style="animation-delay:.2s">
        <div class="rounded-2xl bg-white/80 p-3 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl">
          <div class="flex items-center justify-between gap-1"><span class="text-[10px] font-bold uppercase tracking-[0.14em] text-emerald-500">Hadir</span><span class="grid h-7 w-7 place-items-center rounded-lg bg-emerald-50 text-emerald-500 ring-1 ring-emerald-100"><i class="fa-solid fa-user-check text-[10px]" aria-hidden="true"></i></span></div>
          <p class="mt-1 text-2xl font-extrabold tabular-nums text-emerald-600">{{ $rekap['hadir'] }}</p><p class="text-[10px] text-slate-400">hari</p>
        </div>
        <div class="rounded-2xl bg-white/80 p-3 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl">
          <div class="flex items-center justify-between gap-1"><span class="text-[10px] font-bold uppercase tracking-[0.14em] text-amber-500">Izin</span><span class="grid h-7 w-7 place-items-center rounded-lg bg-amber-50 text-amber-500 ring-1 ring-amber-100"><i class="fa-solid fa-envelope-open-text text-[10px]" aria-hidden="true"></i></span></div>
          <p class="mt-1 text-2xl font-extrabold tabular-nums text-amber-600">{{ $rekap['izin'] }}</p><p class="text-[10px] text-slate-400">hari</p>
        </div>
        <div class="rounded-2xl bg-white/80 p-3 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl">
          <div class="flex items-center justify-between gap-1"><span class="text-[10px] font-bold uppercase tracking-[0.14em] text-violet-500">Sakit</span><span class="grid h-7 w-7 place-items-center rounded-lg bg-violet-50 text-violet-500 ring-1 ring-violet-100"><i class="fa-solid fa-notes-medical text-[10px]" aria-hidden="true"></i></span></div>
          <p class="mt-1 text-2xl font-extrabold tabular-nums text-violet-600">{{ $rekap['sakit'] }}</p><p class="text-[10px] text-slate-400">hari</p>
        </div>
        <div class="rounded-2xl bg-white/80 p-3 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl">
          <div class="flex items-center justify-between gap-1"><span class="text-[10px] font-bold uppercase tracking-[0.14em] text-rose-500">Alpha</span><span class="grid h-7 w-7 place-items-center rounded-lg bg-rose-50 text-rose-500 ring-1 ring-rose-100"><i class="fa-solid fa-user-xmark text-[10px]" aria-hidden="true"></i></span></div>
          <p class="mt-1 text-2xl font-extrabold tabular-nums text-rose-600">{{ $rekap['alpha'] }}</p><p class="text-[10px] text-slate-400">hari</p>
        </div>
        <div class="col-span-2 rounded-2xl bg-white/80 p-3 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl md:col-span-1">
          <div class="flex items-center justify-between gap-1"><span class="text-[10px] font-bold uppercase tracking-[0.14em] text-slate-500">Belum Input</span><span class="grid h-7 w-7 place-items-center rounded-lg bg-slate-50 text-slate-500 ring-1 ring-slate-100"><i class="fa-solid fa-circle-question text-[10px]" aria-hidden="true"></i></span></div>
          <p class="mt-1 text-2xl font-extrabold tabular-nums text-slate-600">{{ $rekap['kosong'] }}</p><p class="text-[10px] text-slate-400">dari {{ $daysInMonth }} hari</p>
        </div>
      </div>
      <div class="vch-in overflow-hidden rounded-3xl bg-white/80 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(79,70,229,.45)] backdrop-blur-xl" style="animation-delay:.25s">
        <div class="grid grid-cols-7 border-b border-slate-100 bg-slate-50/80 text-[11px] font-bold uppercase tracking-wide text-slate-400">
          <div class="py-2 text-center text-xs">Sen</div><div class="py-2 text-center text-xs">Sel</div><div class="py-2 text-center text-xs">Rab</div><div class="py-2 text-center text-xs">Kam</div><div class="py-2 text-center text-xs">Jum</div><div class="py-2 text-center text-xs text-slate-400">Sab</div><div class="py-2 text-center text-xs text-rose-400">Min</div>
        </div>
        <div class="grid grid-cols-7 gap-px bg-slate-100">
          @for($i=0;$i<$offset;$i++)<div class="min-h-[48px] bg-slate-50/60 md:min-h-[52px]"></div>@endfor
          @for($d=1;$d<=$daysInMonth;$d++)
            @php
              $date = \Carbon\Carbon::create($tahun,$bulan,$d);
              $key = $date->format('Y-m-d');
              $pres = $grouped->get($key);
              $status = $pres->status ?? null;
              $isToday = $key === $todayStr;
              $isWeekend = $date->isWeekend();
              $isSunday = $date->isSunday();
              $bulkUrl = route('presences.bulk', ['tanggal'=>$key]);
              $c = $status ? ($cfg[$status] ?? null) : null;
            @endphp
            <a href="{{ $bulkUrl }}" class="group relative flex min-h-[48px] flex-col p-1.5 text-left transition hover:brightness-[0.98] md:min-h-[52px] {{ $status ? $c['bg'].' '.$c['bd'].' border' : 'border border-transparent '.($isWeekend ? ($isSunday ? 'bg-rose-50/70' : 'bg-slate-50') : 'bg-white') }} {{ $isToday ? 'z-10 ring-2 ring-indigo-400 ring-inset' : '' }}" title="Bulk {{ $date->translatedFormat('l, d F Y') }}">
              <div class="flex items-center justify-between">
                <span class="grid h-5 w-5 place-items-center rounded-lg text-[10px] font-bold {{ $isToday ? 'bg-gradient-to-br from-indigo-600 to-violet-600 text-white shadow-sm shadow-indigo-500/30' : '' }} {{ !$isToday && $isSunday ? 'bg-rose-100 text-rose-600' : '' }} {{ !$isToday && !$isSunday && $isWeekend ? 'bg-slate-100 text-slate-500' : '' }} {{ !$isToday && !$isWeekend ? 'bg-slate-100 text-slate-700 group-hover:bg-white' : '' }}">{{ $d }}</span>
                @if($isToday)<span class="hidden text-[9px] font-bold text-indigo-600 md:inline">HARI INI</span>@endif
              </div>
              <div class="mt-0.5 flex flex-1 flex-col items-center justify-center gap-0.5">
                @if($status)
                  <span class="inline-flex items-center gap-1 rounded-full px-1 py-0.5 text-[8px] font-extrabold tracking-wide {{ $c['badge'] }}"><span class="h-1 w-1 rounded-full bg-white/90"></span> {{ $c['label'] }}</span>
                  @if($isWeekend)<span class="rounded border bg-white/80 px-1.5 py-0.5 text-[9px] font-semibold {{ $isSunday ? 'border-rose-200 text-rose-600' : 'border-slate-200 text-slate-500' }}">LIBUR</span>@endif
                @else
                  @if($isWeekend)
                    <span class="rounded-full border px-2 py-1 text-[10px] font-bold {{ $isSunday ? 'border-rose-200 bg-rose-100 text-rose-600' : 'border-slate-200 bg-slate-100 text-slate-500' }}"><i class="fa-solid fa-umbrella-beach mr-1" aria-hidden="true"></i>LIBUR</span>
                    <span class="text-[9px] text-slate-400">tanpa presensi</span>
                  @else
                    <span class="text-[10px] font-medium text-slate-300">-</span><span class="hidden text-[9px] text-slate-400 md:inline">belum input</span>
                  @endif
                @endif
              </div>
              <span class="absolute bottom-0.5 right-0.5 hidden h-4 w-4 place-items-center rounded-lg bg-gradient-to-br from-indigo-600 to-violet-600 text-[10px] text-white opacity-0 transition group-hover:opacity-100 md:grid"><i class="fa-solid fa-pen" aria-hidden="true"></i></span>
            </a>
          @endfor
          @php $totalCells = $offset + $daysInMonth; $remain = (7 - ($totalCells % 7)) % 7; @endphp
          @for($i=0;$i<$remain;$i++)<div class="min-h-[48px] bg-slate-50 md:min-h-[52px]"></div>@endfor
        </div>
        <div class="flex flex-wrap items-center gap-3 border-t border-slate-100 bg-slate-50/70 p-3 text-xs">
          <span class="font-semibold text-slate-600">Keterangan:</span>
          <span class="inline-flex items-center gap-1.5 text-slate-500"><span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span> Hadir</span>
          <span class="inline-flex items-center gap-1.5 text-slate-500"><span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span> Izin</span>
          <span class="inline-flex items-center gap-1.5 text-slate-500"><span class="h-2.5 w-2.5 rounded-full bg-violet-500"></span> Sakit</span>
          <span class="inline-flex items-center gap-1.5 text-slate-500"><span class="h-2.5 w-2.5 rounded-full bg-rose-500"></span> Alpha</span>
          <span class="inline-flex items-center gap-1.5 text-slate-500"><span class="h-2.5 w-2.5 rounded-full border border-slate-200 bg-slate-100"></span> Sabtu</span>
          <span class="inline-flex items-center gap-1.5 text-slate-500"><span class="h-2.5 w-2.5 rounded-full border border-rose-200 bg-rose-100"></span> Minggu / LIBUR</span>
          <span class="ml-auto text-[11px] text-slate-400"><i class="fa-solid fa-hand-pointer mr-1" aria-hidden="true"></i> Klik tanggal &rarr; Bulk (prefill tanggal)</span>
        </div>
      </div>

      <div class="vch-in mt-3 flex flex-wrap gap-2" style="animation-delay:.3s">
        <a href="{{ route('presences.bulk', ['tanggal'=>now()->format('Y-m-d')]) }}" class="inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-500 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2"><i class="fa-solid fa-list-check" aria-hidden="true"></i> Bulk Hari Ini ({{ now()->translatedFormat('d M') }})</a>
      </div>
    @endif
  </div>
</div>
@endsection
