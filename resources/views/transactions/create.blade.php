@extends('layouts.app')
@section('title','Jual Voucher')
@section('content')
<h1 class="text-lg font-bold mb-1">Jual Voucher ke Reseller</h1>
<p class="text-xs text-slate-500 mb-3">Isi jumlah per jenis vocer. Isi <b>0</b> untuk jenis yang tidak dibeli. 1 kali simpan bisa 3 jenis sekaligus.</p>

<div class="grid md:grid-cols-3 gap-4 max-w-4xl">
  <div class="bg-white rounded-2xl border shadow-sm p-3 h-fit">
    <h3 class="font-semibold text-sm text-[#1b2d4a]"><i class="fa-solid fa-tags mr-1 text-[#f68b1e]"></i> Pricelist Vocer</h3>
    <div class="mt-2 space-y-2 text-xs">
      @foreach($types as $k=>$t)
      <div class="flex justify-between items-center border rounded-xl px-3 py-2.5 {{ $k=='5k'?'bg-amber-50 border-amber-200':'bg-slate-50' }}">
        <div><div class="font-bold">{{ $t['label'] }} <span class="font-normal text-slate-500">({{ $k }})</span></div><div class="text-slate-500">Ecer {{ number_format($t['retail'],0,',','.') }} &middot; Margin {{ number_format($t['margin'],0,',','.') }}</div></div>
        <div class="text-right"><div class="font-bold text-[#1b2d4a]">Rp {{ number_format($t['reseller'],0,',','.') }}</div><div class="text-[11px] text-slate-500">ke reseller</div></div>
      </div>
      @endforeach
    </div>
    <div class="mt-3 bg-[#1b2d4a] text-white rounded-xl p-3 text-xs">
      <div class="font-semibold"><i class="fa-solid fa-circle-info mr-1 text-[#f68b1e]"></i> Contoh</div>
      <div class="text-white/80 mt-1">Contoh: 5&times;3K + 10&times;5K = <b class="text-white">Rp 52.500</b>. Isi 0 untuk 10K.</div>
    </div>
  </div>

  <form method="POST" action="{{ route('transactions.store') }}" id="formVocer" class="md:col-span-2 bg-white p-4 rounded-2xl shadow-sm border space-y-3">
  @csrf
  <label class="block text-sm">Reseller* <select name="reseller_id" required class="w-full mt-1 border rounded-xl px-3 py-2.5 text-sm"><option value="">-- Pilih Reseller --</option>@foreach($resellers as $r)<option value="{{ $r->id }}" {{ old('reseller_id')==$r->id?'selected':'' }}>{{ $r->nama }} @if($r->no_hp) - {{ $r->no_hp }} @endif</option>@endforeach</select> <a href="{{ route('resellers.create') }}" class="text-xs text-sky-600 hover:underline">+ Tambah reseller</a></label>

  <div class="space-y-2">
    <div class="text-xs font-semibold text-slate-600">Jumlah per Jenis* <span class="font-normal text-slate-400">isi 0 jika tidak beli</span></div>
    <div class="grid grid-cols-3 gap-2">
      <label class="block border rounded-xl p-2.5 bg-slate-50"><div class="text-xs font-bold">3.000 <span class="text-slate-400 font-normal">@2.500</span></div><input type="number" name="qty_3k" id="qty_3k" value="{{ old('qty_3k',0) }}" min="0" max="10000" class="w-full mt-1 border rounded-lg px-3 py-2 text-sm font-semibold" placeholder="0"><div class="text-[11px] text-slate-500 mt-1" id="sub_3k">Rp 0</div></label>
      <label class="block border rounded-xl p-2.5 bg-amber-50"><div class="text-xs font-bold">5.000 <span class="text-slate-400 font-normal">@4.000</span></div><input type="number" name="qty_5k" id="qty_5k" value="{{ old('qty_5k',0) }}" min="0" max="10000" class="w-full mt-1 border rounded-lg px-3 py-2 text-sm font-semibold" placeholder="0"><div class="text-[11px] text-slate-500 mt-1" id="sub_5k">Rp 0</div></label>
      <label class="block border rounded-xl p-2.5 bg-slate-50"><div class="text-xs font-bold">10.000 <span class="text-slate-400 font-normal">@9.000</span></div><input type="number" name="qty_10k" id="qty_10k" value="{{ old('qty_10k',0) }}" min="0" max="10000" class="w-full mt-1 border rounded-lg px-3 py-2 text-sm font-semibold" placeholder="0"><div class="text-[11px] text-slate-500 mt-1" id="sub_10k">Rp 0</div></label>
    </div>
    @error('qty_5k')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
  </div>
  <div id="preview" class="bg-amber-50 border border-amber-200 rounded-xl p-3 flex justify-between items-center"><div class="text-xs text-amber-800"><div>Total Tagihan</div><div class="text-[11px] text-amber-700" id="previewRincian">isi jumlah dulu</div></div><div class="text-lg font-bold text-[#1b2d4a]" id="previewNominal">Rp 0</div></div>

  <label class="block text-sm">Tanggal*<input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full mt-1 border rounded-xl px-3 py-2.5"></label>

  <label class="block text-sm">Status Pembayaran*
    <div class="flex gap-3 mt-1">
      <label class="flex-1 border rounded-xl px-3 py-2.5 flex items-center gap-2 cursor-pointer has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-300"><input type="radio" name="status" value="lunas" {{ old('status')=='lunas'?'checked':'' }} required> <span class="text-emerald-700 font-semibold text-sm">Lunas</span></label>
      <label class="flex-1 border rounded-xl px-3 py-2.5 flex items-center gap-2 cursor-pointer has-[:checked]:bg-red-50 has-[:checked]:border-red-300"><input type="radio" name="status" value="belum_lunas" {{ old('status','belum_lunas')=='belum_lunas'?'checked':'' }} required> <span class="text-red-700 font-semibold text-sm">Belum Lunas</span></label>
    </div>
  </label>
  <label class="block text-sm">Keterangan<textarea name="keterangan" rows="2" class="w-full mt-1 border rounded-xl px-3 py-2 text-sm" placeholder="Otomatis: mis 10 voucher 5.000">{{ old('keterangan') }}</textarea></label>
  <div class="flex gap-2 pt-1"><button class="bg-[#1b2d4a] hover:bg-[#16233a] text-white px-6 py-2.5 rounded-xl font-semibold text-sm">Simpan</button><a href="{{ route('transactions.index') }}" class="px-6 py-2.5 border rounded-xl text-sm">Batal</a></div>
  </form>
</div>
@push('js')
<script>
const q3=document.getElementById('qty_3k'),q5=document.getElementById('qty_5k'),q10=document.getElementById('qty_10k');
const out=document.getElementById('previewNominal'),det=document.getElementById('previewRincian');
const s3=document.getElementById('sub_3k'),s5=document.getElementById('sub_5k'),s10=document.getElementById('sub_10k');
const form=document.getElementById('formVocer');
function upd(){const a=parseInt(q3.value||0),b=parseInt(q5.value||0),c=parseInt(q10.value||0);const t3=a*2500,t5=b*4000,t10=c*9000;const tot=t3+t5+t10;
s3.textContent='Rp '+t3.toLocaleString('id-ID');s5.textContent='Rp '+t5.toLocaleString('id-ID');s10.textContent='Rp '+t10.toLocaleString('id-ID');
out.textContent='Rp '+tot.toLocaleString('id-ID');const parts=[];if(a>0)parts.push(a+'x3K');if(b>0)parts.push(b+'x5K');if(c>0)parts.push(c+'x10K');
det.textContent=parts.length?parts.join(' + ')+' = Rp '+tot.toLocaleString('id-ID'):'isi jumlah dulu (0 = tidak beli)';}
[q3,q5,q10].forEach(el=>el.addEventListener('input',upd));form.addEventListener('submit',e=>{if((parseInt(q3.value||0)+parseInt(q5.value||0)+parseInt(q10.value||0))==0){e.preventDefault();alert('Isi minimal 1 jenis vocer (>0). Yang tidak dibeli biarkan 0.');}});upd();
</script>
@endpush
@endsection