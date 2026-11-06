@extends('layouts.app')
@section('title','Jual Voucher')
@section('content')
<div class="relative">
  <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
    <div class="absolute -left-20 -top-24 h-72 w-72 rounded-full bg-blue-300/40 blur-3xl"></div>
    <div class="absolute -right-16 top-16 h-80 w-80 rounded-full bg-blue-300/30 blur-3xl"></div>
  </div>
  <div class="relative z-10">
    <div class="vch-in mb-4 flex flex-wrap items-center gap-3">
      <span class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-600/30"><i class="fa-solid fa-ticket" aria-hidden="true"></i></span>
      <div class="min-w-0">
        <h1 class="text-xl font-extrabold tracking-tight text-slate-800">Jual Voucher ke Reseller</h1>
        <p class="text-xs text-slate-500">Isi jumlah per jenis vocer. Isi <b class="text-slate-700">0</b> untuk jenis yang tidak dibeli &mdash; 1 kali simpan bisa 3 jenis sekaligus.</p>
      </div>
    </div>

    <div class="flex flex-col md:grid md:grid-cols-3 max-w-4xl gap-4">
      <div class="vch-in order-2 md:order-1 h-fit rounded-3xl bg-white/80 p-4 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(37,99,235,.45)] backdrop-blur-xl" style="animation-delay:.05s">
        <div class="mb-3 flex items-center gap-2.5">
          <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-600/30"><i class="fa-solid fa-tags text-sm" aria-hidden="true"></i></span>
          <div>
            <h3 class="font-bold leading-tight text-slate-800">Pricelist Vocer</h3>
            <p class="text-[11px] text-slate-400">Harga khusus reseller</p>
          </div>
        </div>
        <div class="space-y-2 text-xs">
          @foreach($types as $k=>$t)
          <div class="flex items-center justify-between gap-2 rounded-2xl px-3 py-2.5 ring-1 {{ $k=='5k' ? 'bg-gradient-to-r from-amber-50 to-orange-50 ring-amber-100' : 'bg-slate-50/80 ring-slate-100' }}">
            <div class="min-w-0">
              <div class="font-bold text-slate-800">{{ $t['label'] }} <span class="font-normal text-slate-400">({{ $k }})</span></div>
              <div class="text-slate-500">Ecer {{ number_format($t['retail'],0,',','.') }} &middot; Margin {{ number_format($t['margin'],0,',','.') }}</div>
            </div>
            <div class="shrink-0 text-right">
              <div class="font-bold tabular-nums text-blue-600">Rp {{ number_format($t['reseller'],0,',','.') }}</div>
              <div class="text-[11px] text-slate-400">ke reseller</div>
            </div>
          </div>
          @endforeach
        </div>
        <div class="relative mt-3 overflow-hidden rounded-2xl bg-blue-600 p-3 text-xs text-white shadow-lg shadow-blue-600/25">
          <span class="pointer-events-none absolute -right-6 -top-6 h-16 w-16 rounded-full bg-white/15" aria-hidden="true"></span>
          <div class="relative font-semibold"><i class="fa-solid fa-circle-info mr-1 text-blue-200" aria-hidden="true"></i> Contoh</div>
          <div class="relative mt-1 text-white/80">Contoh: 5&times;3K + 10&times;5K = <b class="text-white">Rp 52.500</b>. Isi 0 untuk 10K.</div>
        </div>
      </div>

  <form method="POST" action="{{ route('transactions.store') }}" id="formVocer" class="vch-in order-1 md:order-2 space-y-3 rounded-3xl bg-white/80 p-4 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(37,99,235,.45)] backdrop-blur-xl md:col-span-2 md:p-5" style="animation-delay:.1s">
  @csrf
  <label class="block text-sm font-medium text-slate-700">Reseller* <select name="reseller_id" required class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"><option value="">-- Pilih Reseller --</option>@foreach($resellers as $r)<option value="{{ $r->id }}" {{ old('reseller_id')==$r->id?'selected':'' }}>{{ $r->nama }} @if($r->no_hp) - {{ $r->no_hp }} @endif</option>@endforeach</select> <a href="{{ route('resellers.create') }}" class="text-xs font-semibold text-blue-600 hover:underline">+ Tambah reseller</a></label>

  <div class="space-y-2">
    <div class="text-xs font-semibold text-slate-600">Jumlah per Jenis* <span class="font-normal text-slate-400">isi 0 jika tidak beli</span></div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
      <label class="block rounded-2xl bg-slate-50/80 p-3 ring-1 ring-slate-100 transition focus-within:ring-2 focus-within:ring-blue-200">
        <div class="flex items-center justify-between gap-1">
          <div class="text-xs font-bold text-slate-800">{{ $types['3k']['label'] ?? '3.000' }} <span class="font-normal text-slate-400">@ {{ number_format($types['3k']['reseller'] ?? 2500, 0, ',', '.') }}</span></div>
          <div class="text-[11px] font-semibold tabular-nums text-blue-600" id="sub_3k">Rp 0</div>
        </div>
        <input type="number" name="qty_3k" id="qty_3k" value="{{ old('qty_3k',0) }}" min="0" max="10000" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold tabular-nums text-slate-800 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100" placeholder="0">
      </label>
      <label class="block rounded-2xl bg-gradient-to-r from-amber-50 to-orange-50 p-3 ring-1 ring-amber-100 transition focus-within:ring-2 focus-within:ring-amber-300">
        <div class="flex items-center justify-between gap-1">
          <div class="text-xs font-bold text-slate-800">{{ $types['5k']['label'] ?? '5.000' }} <span class="font-normal text-amber-600/70">@ {{ number_format($types['5k']['reseller'] ?? 4000, 0, ',', '.') }}</span></div>
          <div class="text-[11px] font-semibold tabular-nums text-amber-600" id="sub_5k">Rp 0</div>
        </div>
        <input type="number" name="qty_5k" id="qty_5k" value="{{ old('qty_5k',0) }}" min="0" max="10000" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold tabular-nums text-slate-800 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-100" placeholder="0">
      </label>
      <label class="block rounded-2xl bg-slate-50/80 p-3 ring-1 ring-slate-100 transition focus-within:ring-2 focus-within:ring-blue-200">
        <div class="flex items-center justify-between gap-1">
          <div class="text-xs font-bold text-slate-800">{{ $types['10k']['label'] ?? '10.000' }} <span class="font-normal text-slate-400">@ {{ number_format($types['10k']['reseller'] ?? 9000, 0, ',', '.') }}</span></div>
          <div class="text-[11px] font-semibold tabular-nums text-blue-600" id="sub_10k">Rp 0</div>
        </div>
        <input type="number" name="qty_10k" id="qty_10k" value="{{ old('qty_10k',0) }}" min="0" max="10000" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold tabular-nums text-slate-800 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100" placeholder="0">
      </label>
    </div>
    @error('qty_5k')<div class="rounded-lg bg-rose-50 px-3 py-2 text-xs text-rose-600 ring-1 ring-rose-100">{{ $message }}</div>@enderror
  </div>
  <div id="preview" class="flex items-center justify-between gap-2 rounded-2xl bg-blue-50 p-3 ring-1 ring-blue-100"><div class="text-xs text-slate-600"><div class="font-semibold text-slate-700">Total Tagihan</div><div class="text-[11px] text-slate-500" id="previewRincian">isi jumlah dulu</div></div><div class="text-lg font-extrabold tabular-nums text-blue-600" id="previewNominal">Rp 0</div></div>

  <label class="block text-sm font-medium text-slate-700">Tanggal*<input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"></label>

  <label class="block text-sm font-medium text-slate-700">Status Pembayaran*
    <div class="mt-1 grid grid-cols-2 gap-2 sm:gap-3">
      <label class="flex cursor-pointer items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2.5 transition has-[:checked]:border-emerald-300 has-[:checked]:bg-emerald-50 has-[:checked]:ring-2 has-[:checked]:ring-emerald-200"><input type="radio" name="status" value="lunas" {{ old('status')=='lunas'?'checked':'' }} required class="accent-emerald-600"> <span class="text-xs sm:text-sm font-semibold text-emerald-700">Lunas</span></label>
      <label class="flex cursor-pointer items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2.5 transition has-[:checked]:border-rose-300 has-[:checked]:bg-rose-50 has-[:checked]:ring-2 has-[:checked]:ring-rose-200"><input type="radio" name="status" value="belum_lunas" {{ old('status','belum_lunas')=='belum_lunas'?'checked':'' }} required class="accent-rose-600"> <span class="text-xs sm:text-sm font-semibold text-rose-700">Belum Lunas</span></label>
    </div>
  </label>
  <label class="block text-sm font-medium text-slate-700">Keterangan<textarea name="keterangan" rows="2" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100" placeholder="Otomatis: mis 10 voucher 5.000">{{ old('keterangan') }}</textarea></label>
  <div class="flex flex-col sm:flex-row gap-2 pt-1"><button class="w-full sm:w-auto rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-600/25 transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">Simpan</button><a href="{{ route('transactions.index') }}" class="w-full sm:w-auto text-center rounded-xl bg-white px-6 py-2.5 text-sm font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-blue-50 hover:text-blue-600">Batal</a></div>
  </form>
    </div>
  </div>
</div>
@push('js')
<script>
(function() {
  const q3 = document.getElementById('qty_3k');
  const q5 = document.getElementById('qty_5k');
  const q10 = document.getElementById('qty_10k');
  const out = document.getElementById('previewNominal');
  const det = document.getElementById('previewRincian');
  const s3 = document.getElementById('sub_3k');
  const s5 = document.getElementById('sub_5k');
  const s10 = document.getElementById('sub_10k');
  const form = document.getElementById('formVocer');

  const p3 = {{ (int) ($types['3k']['reseller'] ?? 2500) }};
  const p5 = {{ (int) ($types['5k']['reseller'] ?? 4000) }};
  const p10 = {{ (int) ($types['10k']['reseller'] ?? 9000) }};

  function parseVal(el) {
    if (!el) return 0;
    const v = parseInt(el.value, 10);
    return isNaN(v) || v < 0 ? 0 : v;
  }

  function upd() {
    const a = parseVal(q3);
    const b = parseVal(q5);
    const c = parseVal(q10);
    const t3 = a * p3;
    const t5 = b * p5;
    const t10 = c * p10;
    const tot = t3 + t5 + t10;

    if (s3) s3.textContent = 'Rp ' + t3.toLocaleString('id-ID');
    if (s5) s5.textContent = 'Rp ' + t5.toLocaleString('id-ID');
    if (s10) s10.textContent = 'Rp ' + t10.toLocaleString('id-ID');
    if (out) out.textContent = 'Rp ' + tot.toLocaleString('id-ID');

    const parts = [];
    if (a > 0) parts.push(a + 'x 3K');
    if (b > 0) parts.push(b + 'x 5K');
    if (c > 0) parts.push(c + 'x 10K');

    if (det) {
      det.textContent = parts.length
        ? parts.join(' + ') + ' = Rp ' + tot.toLocaleString('id-ID')
        : 'isi jumlah dulu (0 = tidak beli)';
    }
  }

  [q3, q5, q10].forEach(function(el) {
    if (!el) return;
    ['input', 'change', 'keyup'].forEach(function(ev) {
      el.addEventListener(ev, upd);
    });
  });

  if (form) {
    form.addEventListener('submit', function(e) {
      const totalQty = parseVal(q3) + parseVal(q5) + parseVal(q10);
      if (totalQty === 0) {
        e.preventDefault();
        alert('Isi minimal 1 jenis vocer (>0). Yang tidak dibeli biarkan 0.');
      }
    });
  }

  upd();
})();
</script>
@endpush
@endsection