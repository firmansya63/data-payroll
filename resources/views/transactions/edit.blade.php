@extends('layouts.app')
@section('title','Edit Transaksi')
@section('content')
<div class="relative">
  <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
    <div class="absolute -left-20 -top-24 h-72 w-72 rounded-full bg-blue-300/40 blur-3xl"></div>
    <div class="absolute -right-16 top-16 h-80 w-80 rounded-full bg-blue-300/30 blur-3xl"></div>
  </div>
  <div class="relative z-10">
    <div class="vch-in mb-4 flex flex-wrap items-center justify-between gap-3">
      <div class="flex items-center gap-3">
        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 text-white shadow-lg shadow-amber-500/30"><i class="fa-solid fa-pen-to-square" aria-hidden="true"></i></span>
        <div class="min-w-0">
          <h1 class="text-xl font-extrabold tracking-tight text-slate-800">Edit Transaksi Voucher</h1>
          <p class="text-xs text-slate-500">Ubah jenis/qty &mdash; nominal otomatis menyesuaikan pricelist.</p>
        </div>
      </div>
      <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-1 rounded-xl bg-white px-3 py-2 text-xs font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-blue-50 hover:text-blue-600"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Kembali</a>
    </div>

    <div class="grid max-w-4xl gap-4 md:grid-cols-3">
      <div class="vch-in h-fit rounded-3xl bg-white/80 p-4 text-xs ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(37,99,235,.45)] backdrop-blur-xl" style="animation-delay:.05s">
        <div class="mb-3 flex items-center gap-2.5">
          <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-600/30"><i class="fa-solid fa-tags text-sm" aria-hidden="true"></i></span>
          <div><div class="font-bold leading-tight text-slate-800">Pricelist</div><div class="text-[11px] text-slate-400">Harga ke reseller</div></div>
        </div>
        @foreach($types as $k=>$t)
        <div class="mb-2 flex items-center justify-between gap-2 rounded-2xl px-3 py-2 ring-1 {{ $transaction->voucher_type==$k ? 'bg-blue-600 text-white ring-blue-600 shadow-sm shadow-blue-600/25' : 'bg-slate-50/80 text-slate-700 ring-slate-100' }}">
          <span class="font-bold">{{ $t['label'] }}</span><span class="font-bold tabular-nums">Rp {{ number_format($t['reseller'],0,',','.') }}</span>
        </div>
        @endforeach
        <div class="mt-2 text-slate-400">Ecer: 3K=&gt;3.000 | 5K=&gt;5.000 | 10K=&gt;10.000</div>
      </div>
      <form method="POST" action="{{ route('transactions.update',$transaction) }}" id="formVocer" class="vch-in space-y-3 rounded-3xl bg-white/80 p-4 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(37,99,235,.45)] backdrop-blur-xl md:col-span-2 md:p-5" style="animation-delay:.1s">
  @csrf @method('PUT')
  <label class="block text-sm font-medium text-slate-700">Reseller*<select name="reseller_id" required class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">@foreach($resellers as $r)<option value="{{ $r->id }}" {{ old('reseller_id',$transaction->reseller_id)==$r->id?'selected':'' }}>{{ $r->nama }}</option>@endforeach</select></label>
  <div class="grid grid-cols-2 gap-3">
    <label class="block text-sm font-medium text-slate-700">Jenis Vocer*<select name="voucher_type" id="voucher_type" required class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">@foreach($types as $k=>$t)<option value="{{ $k }}" data-reseller="{{ $t['reseller'] }}" data-retail="{{ $t['retail'] }}" {{ old('voucher_type',$transaction->voucher_type ?: '5k')==$k?'selected':'' }}>{{ $t['label'] }} - Rp {{ number_format($t['reseller'],0,',','.') }}</option>@endforeach</select></label>
    <label class="block text-sm font-medium text-slate-700">Jumlah*<input type="number" name="qty" id="qty" value="{{ old('qty',$transaction->qty ?: 1) }}" required min="1" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold tabular-nums text-slate-800 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"></label>
  </div>
  <div id="preview" class="flex items-center justify-between gap-2 rounded-2xl bg-blue-50 p-3 ring-1 ring-blue-100"><span class="text-xs text-slate-600" id="previewRincian">-</span><span class="text-lg font-extrabold tabular-nums text-blue-600" id="previewNominal">-</span></div>
  <label class="block text-sm font-medium text-slate-700">Tanggal*<input type="date" name="tanggal" value="{{ old('tanggal',$transaction->tanggal->format('Y-m-d')) }}" required class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"></label>
  <label class="block text-sm font-medium text-slate-700">Status*
    <div class="mt-1 flex gap-3">
      <label class="flex flex-1 cursor-pointer items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2.5 transition has-[:checked]:border-emerald-300 has-[:checked]:bg-emerald-50 has-[:checked]:ring-2 has-[:checked]:ring-emerald-200"><input type="radio" name="status" value="lunas" {{ old('status',$transaction->status)=='lunas'?'checked':'' }} required class="accent-emerald-600"> <span class="text-sm font-semibold text-emerald-700">Lunas</span></label>
      <label class="flex flex-1 cursor-pointer items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2.5 transition has-[:checked]:border-rose-300 has-[:checked]:bg-rose-50 has-[:checked]:ring-2 has-[:checked]:ring-rose-200"><input type="radio" name="status" value="belum_lunas" {{ old('status',$transaction->status)=='belum_lunas'?'checked':'' }} required class="accent-rose-600"> <span class="text-sm font-semibold text-rose-700">Belum Lunas</span></label>
    </div>
  </label>
  <label class="block text-sm font-medium text-slate-700">Keterangan<textarea name="keterangan" rows="2" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">{{ old('keterangan',$transaction->keterangan) }}</textarea></label>
  <div class="flex gap-2 pt-1"><button class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-600/25 transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">Update</button><a href="{{ route('transactions.index') }}" class="rounded-xl bg-white px-6 py-2.5 text-sm font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-blue-50 hover:text-blue-600">Batal</a></div>
  </form>
    </div>
  </div>
</div>
@push('js')
<script>const sel=document.getElementById('voucher_type'),qty=document.getElementById('qty'),out=document.getElementById('previewNominal'),det=document.getElementById('previewRincian');function upd(){const o=sel.options[sel.selectedIndex];const res=parseInt(o.dataset.reseller);const q=parseInt(qty.value||0);out.textContent='Rp '+(q*res).toLocaleString('id-ID');det.textContent=q+' x '+o.textContent.split(' -')[0]+' @'+res.toLocaleString('id-ID');}sel.addEventListener('change',upd);qty.addEventListener('input',upd);upd();</script>
@endpush
@endsection