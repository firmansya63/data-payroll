@extends('layouts.app')
@section('title','Edit Transaksi')
@section('content')
<h1 class="text-lg font-bold mb-1">Edit Transaksi Voucher</h1>
<p class="text-xs text-slate-500 mb-3">Ubah jenis/qty, nominal otomatis menyesuaikan pricelist.</p>
<div class="grid md:grid-cols-3 gap-4 max-w-4xl">
  <div class="bg-white rounded-2xl border shadow-sm p-3 h-fit text-xs">
    @foreach($types as $k=>$t)
    <div class="flex justify-between items-center border rounded-xl px-3 py-2 mb-2 {{ $transaction->voucher_type==$k?'bg-[#1b2d4a] text-white border-[#1b2d4a]':'bg-slate-50' }}">
      <span class="font-bold">{{ $t['label'] }}</span><span class="font-bold">Rp {{ number_format($t['reseller'],0,',','.') }}</span>
    </div>
    @endforeach
    <div class="text-slate-500 mt-2">Ecer: 3K=&gt;3.000 | 5K=&gt;5.000 | 10K=&gt;10.000</div>
  </div>
  <form method="POST" action="{{ route('transactions.update',$transaction) }}" id="formVocer" class="md:col-span-2 bg-white p-4 rounded-2xl shadow-sm border space-y-3">
  @csrf @method('PUT')
  <label class="block text-sm">Reseller*<select name="reseller_id" required class="w-full mt-1 border rounded-xl px-3 py-2.5 text-sm">@foreach($resellers as $r)<option value="{{ $r->id }}" {{ old('reseller_id',$transaction->reseller_id)==$r->id?'selected':'' }}>{{ $r->nama }}</option>@endforeach</select></label>
  <div class="grid grid-cols-2 gap-3">
    <label class="block text-sm">Jenis Vocer*<select name="voucher_type" id="voucher_type" required class="w-full mt-1 border rounded-xl px-3 py-2.5 text-sm">@foreach($types as $k=>$t)<option value="{{ $k }}" data-reseller="{{ $t['reseller'] }}" data-retail="{{ $t['retail'] }}" {{ old('voucher_type',$transaction->voucher_type ?: '5k')==$k?'selected':'' }}>{{ $t['label'] }} - Rp {{ number_format($t['reseller'],0,',','.') }}</option>@endforeach</select></label>
    <label class="block text-sm">Jumlah*<input type="number" name="qty" id="qty" value="{{ old('qty',$transaction->qty ?: 1) }}" required min="1" class="w-full mt-1 border rounded-xl px-3 py-2.5"></label>
  </div>
  <div id="preview" class="bg-amber-50 border border-amber-200 rounded-xl p-3 flex justify-between items-center"><span class="text-xs text-amber-800" id="previewRincian">-</span><span class="font-bold" id="previewNominal">-</span></div>
  <label class="block text-sm">Tanggal*<input type="date" name="tanggal" value="{{ old('tanggal',$transaction->tanggal->format('Y-m-d')) }}" required class="w-full mt-1 border rounded-xl px-3 py-2.5"></label>
  <label class="block text-sm">Status*
    <div class="flex gap-3 mt-1">
      <label class="flex-1 border rounded-xl px-3 py-2.5 flex items-center gap-2 cursor-pointer has-[:checked]:bg-emerald-50"><input type="radio" name="status" value="lunas" {{ old('status',$transaction->status)=='lunas'?'checked':'' }} required> <span class="text-emerald-700 font-semibold text-sm">Lunas</span></label>
      <label class="flex-1 border rounded-xl px-3 py-2.5 flex items-center gap-2 cursor-pointer has-[:checked]:bg-red-50"><input type="radio" name="status" value="belum_lunas" {{ old('status',$transaction->status)=='belum_lunas'?'checked':'' }} required> <span class="text-red-700 font-semibold text-sm">Belum Lunas</span></label>
    </div>
  </label>
  <label class="block text-sm">Keterangan<textarea name="keterangan" rows="2" class="w-full mt-1 border rounded-xl px-3 py-2 text-sm">{{ old('keterangan',$transaction->keterangan) }}</textarea></label>
  <div class="flex gap-2 pt-1"><button class="bg-[#1b2d4a] text-white px-6 py-2.5 rounded-xl font-semibold">Update</button><a href="{{ route('transactions.index') }}" class="px-6 py-2.5 border rounded-xl text-sm">Batal</a></div>
  </form>
</div>
@push('js')
<script>const sel=document.getElementById('voucher_type'),qty=document.getElementById('qty'),out=document.getElementById('previewNominal'),det=document.getElementById('previewRincian');function upd(){const o=sel.options[sel.selectedIndex];const res=parseInt(o.dataset.reseller);const q=parseInt(qty.value||0);out.textContent='Rp '+(q*res).toLocaleString('id-ID');det.textContent=q+' x '+o.textContent.split(' -')[0]+' @'+res.toLocaleString('id-ID');}sel.addEventListener('change',upd);qty.addEventListener('input',upd);upd();</script>
@endpush
@endsection