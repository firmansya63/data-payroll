@extends('layouts.app')
@section('title','Nota Barang & Jasa')
@section('content')
<div class="relative">
  <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
    <div class="absolute -left-16 -top-20 h-72 w-72 rounded-full bg-blue-300/40 blur-3xl"></div>
    <div class="absolute -right-10 top-10 h-80 w-80 rounded-full bg-blue-300/30 blur-3xl"></div>
  </div>

  <div class="relative z-10">
    <div class="vch-in mb-3 overflow-hidden rounded-3xl bg-blue-600 px-4 py-4 text-white shadow-[0_18px_45px_-18px_rgba(37,99,235,.65)] md:px-5">
      <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-3">
          <span class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-white/15 ring-1 ring-white/25 backdrop-blur"><i class="fa-solid fa-receipt text-lg" aria-hidden="true"></i></span>
          <div class="min-w-0">
            <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-white/60">Penjualan Manual</p>
            <h1 class="text-xl font-extrabold tracking-tight">Nota Barang & Jasa</h1>
            <p class="text-[11px] text-white/70">Nota penjualan barang/jasa dengan DP, jatuh tempo, dan cetak A4.</p>
          </div>
        </div>
        <a href="{{ route('manual-notas.create') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-white/15 px-4 py-2 text-sm font-semibold text-white ring-1 ring-white/30 backdrop-blur transition hover:bg-white/25"><i class="fa-solid fa-plus" aria-hidden="true"></i> Buat Nota</a>
      </div>
    </div>

    <div class="vch-in mb-3 grid grid-cols-1 gap-2 sm:grid-cols-3" style="animation-delay:.05s">
      <div class="rounded-2xl bg-white/80 p-3 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(37,99,235,.45)] backdrop-blur-xl">
        <div class="flex items-center justify-between gap-2">
          <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-rose-500">Piutang (Sisa)</p>
          <span class="grid h-8 w-8 place-items-center rounded-xl bg-rose-50 text-rose-500 ring-1 ring-rose-100"><i class="fa-solid fa-file-invoice-dollar text-xs" aria-hidden="true"></i></span>
        </div>
        <p class="mt-1 text-lg font-extrabold tabular-nums text-rose-600">Rp {{ number_format($sumPiutang,0,',','.') }}</p>
        <p class="text-[10px] text-slate-400">Belum Lunas + DP</p>
      </div>
      <div class="rounded-2xl bg-white/80 p-3 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(37,99,235,.45)] backdrop-blur-xl">
        <div class="flex items-center justify-between gap-2">
          <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-amber-500">DP Masuk</p>
          <span class="grid h-8 w-8 place-items-center rounded-xl bg-amber-50 text-amber-500 ring-1 ring-amber-100"><i class="fa-solid fa-hand-holding-dollar text-xs" aria-hidden="true"></i></span>
        </div>
        <p class="mt-1 text-lg font-extrabold tabular-nums text-amber-600">Rp {{ number_format($sumDp,0,',','.') }}</p>
        <p class="text-[10px] text-slate-400">Uang muka diterima</p>
      </div>
      <div class="rounded-2xl bg-white/80 p-3 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(37,99,235,.45)] backdrop-blur-xl">
        <div class="flex items-center justify-between gap-2">
          <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-emerald-500">Lunas</p>
          <span class="grid h-8 w-8 place-items-center rounded-xl bg-emerald-50 text-emerald-500 ring-1 ring-emerald-100"><i class="fa-solid fa-circle-check text-xs" aria-hidden="true"></i></span>
        </div>
        <p class="mt-1 text-lg font-extrabold tabular-nums text-emerald-600">Rp {{ number_format($sumLunas,0,',','.') }}</p>
        <p class="text-[10px] text-slate-400">Nota selesai dibayar</p>
      </div>
    </div>

    <form method="GET" class="vch-in mb-3 space-y-2 rounded-3xl bg-white/80 p-3 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(37,99,235,.45)] backdrop-blur-xl" style="animation-delay:.1s">
      <div class="grid grid-cols-2 gap-2 md:grid-cols-7">
        <select name="status" class="rounded-xl border border-slate-200 bg-white px-2 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
          <option value="">Semua Status</option>
          <option value="belum_lunas" {{ request('status')=='belum_lunas'?'selected':'' }}>Belum Lunas</option>
          <option value="dp" {{ request('status')=='dp'?'selected':'' }}>DP</option>
          <option value="lunas" {{ request('status')=='lunas'?'selected':'' }}>Lunas</option>
        </select>
        <select name="jenis" class="rounded-xl border border-slate-200 bg-white px-2 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
          <option value="">Semua Jenis</option>
          <option value="barang" {{ request('jenis')=='barang'?'selected':'' }}>Barang</option>
          <option value="jasa" {{ request('jenis')=='jasa'?'selected':'' }}>Jasa</option>
          <option value="campuran" {{ request('jenis')=='campuran'?'selected':'' }}>Campuran</option>
        </select>
        <input type="date" name="dari" value="{{ request('dari') }}" class="rounded-xl border border-slate-200 bg-white px-2 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
        <input type="date" name="sampai" value="{{ request('sampai') }}" class="rounded-xl border border-slate-200 bg-white px-2 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
        <input name="q" value="{{ request('q') }}" placeholder="No nota / pelanggan" class="rounded-xl border border-slate-200 bg-white px-2 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100 md:col-span-2">
        <button class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-blue-600/25 transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2"><i class="fa-solid fa-filter" aria-hidden="true"></i> Filter</button>
      </div>
      <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('manual-notas.index') }}" class="inline-flex items-center gap-1 rounded-lg bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-slate-50"><i class="fa-solid fa-rotate-left text-[10px]" aria-hidden="true"></i> Reset</a>
        @if(request('q') || request('status') || request('jenis'))<span class="rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-600 ring-1 ring-blue-100">{{ $notas->total() }} nota</span>@endif
        @if(request('status')=='belum_lunas' || request('status')=='dp')<span class="rounded-full bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-600 ring-1 ring-rose-100">Sisa: Rp {{ number_format($totalPiutangFiltered,0,',','.') }}</span>@endif
      </div>
    </form>

    <div class="vch-in overflow-hidden rounded-3xl bg-white/80 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(37,99,235,.45)] backdrop-blur-xl" style="animation-delay:.15s">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-slate-50/80 text-[11px] uppercase tracking-wide text-slate-400">
            <tr>
              <th class="px-3 py-2 text-left">Tgl</th>
              <th class="px-3 py-2 text-left">No Nota</th>
              <th class="px-3 py-2 text-left">Pelanggan</th>
              <th class="px-3 py-2 text-center">Jenis</th>
              <th class="px-3 py-2 text-right">Total</th>
              <th class="px-3 py-2 text-right">Sisa</th>
              <th class="px-3 py-2 text-center">Status</th>
              <th class="px-3 py-2 text-center">Tempo</th>
              <th class="px-3 py-2 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($notas as $n)
            <tr class="border-t border-slate-100 transition hover:bg-blue-50/40">
              <td class="whitespace-nowrap px-3 py-2.5 text-xs text-slate-500">{{ $n->tanggal->format('d/m/y') }}</td>
              <td class="px-3 py-2">
                <div class="font-mono text-xs font-bold text-slate-800">{{ $n->no_nota }}</div>
                <div class="text-[11px] text-slate-400">{{ $n->items->count() }} item</div>
              </td>
              <td class="px-3 py-2">
                <div class="text-sm font-semibold text-slate-700">{{ $n->pelanggan_nama }}</div>
                <div class="text-xs text-slate-400">{{ $n->pelanggan_hp ?? '-' }}</div>
              </td>
              <td class="px-3 py-2 text-center">
                @if($n->jenis=='barang')<span class="rounded-full bg-blue-50 px-2 py-1 text-[10px] font-bold text-blue-600 ring-1 ring-blue-100">BARANG</span>
                @elseif($n->jenis=='jasa')<span class="rounded-full bg-blue-50 px-2 py-1 text-[10px] font-bold text-blue-600 ring-1 ring-blue-100">JASA</span>
                @else<span class="rounded-full bg-amber-50 px-2 py-1 text-[10px] font-bold text-amber-600 ring-1 ring-amber-100">CAMPURAN</span>@endif
              </td>
              <td class="whitespace-nowrap px-3 py-2 text-right font-bold tabular-nums text-slate-800">Rp {{ number_format($n->total,0,',','.') }}</td>
              <td class="whitespace-nowrap px-3 py-2 text-right tabular-nums {{ $n->sisa_tagihan>0?'font-bold text-rose-600':'text-slate-400' }}">Rp {{ number_format($n->sisa_tagihan,0,',','.') }}</td>
              <td class="px-3 py-2 text-center">
                @if($n->status=='lunas')<span class="rounded-full bg-emerald-50 px-2 py-1 text-[10px] font-bold text-emerald-600 ring-1 ring-emerald-100">LUNAS</span>
                @elseif($n->status=='dp')<span class="rounded-full bg-amber-50 px-2 py-1 text-[10px] font-bold text-amber-600 ring-1 ring-amber-100">DP Rp {{ number_format($n->dp_nominal,0,',','.') }}</span>
                @else<span class="rounded-full bg-rose-50 px-2 py-1 text-[10px] font-bold text-rose-600 ring-1 ring-rose-100">BELUM LUNAS</span>@endif
              </td>
              <td class="px-3 py-2 text-center text-xs">
                @if($n->jatuh_tempo)<span class="{{ $n->is_overdue ? 'font-bold text-rose-600' : 'text-slate-600' }}">{{ $n->jatuh_tempo->format('d/m/y') }}</span>@if($n->is_overdue)<div class="text-[10px] text-rose-500">Jatuh tempo</div>@endif
                @else<span class="text-slate-300">-</span>@endif
              </td>
              <td class="px-3 py-2">
                <div class="flex items-center justify-center gap-1.5">
                  <a href="{{ route('manual-notas.nota',$n) }}" target="_blank" rel="noopener" title="Cetak Nota A4 Portrait" aria-label="Cetak Nota A4 Portrait"
                     class="grid h-8 w-8 place-items-center rounded-lg bg-blue-600 text-white shadow-sm shadow-blue-600/30 transition hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-1">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <path d="M7 3h7l5 5v11a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"/>
                      <path d="M14 3v5h5M9 13h6M9 17h4"/>
                    </svg>
                  </a>
                  <a href="{{ route('manual-notas.nota-landscape',$n) }}" target="_blank" rel="noopener" title="Cetak Nota A4 Landscape" aria-label="Cetak Nota A4 Landscape"
                     class="grid h-8 w-8 place-items-center rounded-lg bg-white text-slate-600 ring-1 ring-slate-200 transition hover:bg-slate-50 hover:text-slate-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-1">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <path d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/>
                      <path d="M8 11h8M8 15h5"/>
                    </svg>
                  </a>
                  <a href="{{ route('manual-notas.edit',$n) }}" title="Edit Nota" aria-label="Edit Nota {{ $n->no_nota }}"
                     class="grid h-8 w-8 place-items-center rounded-lg bg-amber-50 text-amber-600 ring-1 ring-amber-100 transition hover:bg-amber-100 hover:text-amber-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-1">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <path d="M12 20h9"/>
                      <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"/>
                    </svg>
                  </a>
                  <a href="{{ route('manual-notas.duplicate',$n) }}" title="Duplikat Nota" aria-label="Duplikat Nota {{ $n->no_nota }}"
                     class="grid h-8 w-8 place-items-center rounded-lg bg-white text-slate-600 ring-1 ring-slate-200 transition hover:bg-slate-50 hover:text-slate-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-1">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <rect x="9" y="9" width="12" height="12" rx="2"/>
                      <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                    </svg>
                  </a>
                  <form method="POST" action="{{ route('manual-notas.destroy',$n) }}" onsubmit="return confirm('Hapus nota {{ $n->no_nota }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" title="Hapus Nota" aria-label="Hapus Nota {{ $n->no_nota }}"
                            class="grid h-8 w-8 place-items-center rounded-lg bg-rose-50 text-rose-600 ring-1 ring-rose-100 transition hover:bg-rose-100 hover:text-rose-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500 focus-visible:ring-offset-1">
                      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 6h18"/>
                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6M14 11v6"/>
                      </svg>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="9" class="px-3 py-10">
                <div class="flex flex-col items-center gap-2 text-center">
                  <span class="grid h-12 w-12 place-items-center rounded-2xl bg-blue-50 text-blue-600 ring-1 ring-blue-100"><i class="fa-solid fa-receipt" aria-hidden="true"></i></span>
                  <p class="text-sm font-semibold text-slate-500">Belum ada nota.</p>
                  <a href="{{ route('manual-notas.create') }}" class="text-xs font-semibold text-blue-600 hover:underline">Buat Nota sekarang</a>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if($notas->hasPages())
      <div class="border-t border-slate-100 p-3">{{ $notas->links() }}</div>
      @endif
    </div>
  </div>
</div>
@endsection
