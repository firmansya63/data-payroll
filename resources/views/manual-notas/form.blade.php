@extends('layouts.app')
@section('title', ($nota ?? null) ? 'Edit Nota '.$nota->no_nota : 'Buat Nota Barang & Jasa')
@section('content')
@php
  $isEdit = isset($nota) && $nota;
  $initItems = [];
  if(old('items')) $initItems = old('items');
  elseif(isset($items) && count($items)) $initItems = collect($items)->map(fn($it)=>[
    'nama'=>$it->nama,'kategori'=>$it->kategori,'qty'=>rtrim(rtrim(number_format($it->qty,2,'.',''), '0'), '.'),'satuan'=>$it->satuan,'harga_satuan'=>$it->harga_satuan,'diskon_item'=>$it->diskon_item,'keterangan_item'=>$it->keterangan_item
  ])->toArray();
  elseif(isset($duplicate)) $initItems = collect($items)->map(fn($it)=>[
    'nama'=>$it->nama,'kategori'=>$it->kategori,'qty'=>rtrim(rtrim(number_format($it->qty,2,'.',''), '0'), '.'),'satuan'=>$it->satuan,'harga_satuan'=>$it->harga_satuan,'diskon_item'=>$it->diskon_item,'keterangan_item'=>$it->keterangan_item
  ])->toArray();
  if(empty($initItems)) $initItems = [['nama'=>'','kategori'=>'barang','qty'=>1,'satuan'=>'pcs','harga_satuan'=>'','diskon_item'=>0,'keterangan_item'=>'']];
  $suggestedNo = $suggestedNo ?? '';
@endphp
<div class="relative">
  <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
    <div class="absolute -left-16 -top-20 h-72 w-72 rounded-full bg-blue-300/40 blur-3xl"></div>
    <div class="absolute -right-10 top-10 h-80 w-80 rounded-full bg-blue-300/30 blur-3xl"></div>
  </div>

  <div class="relative z-10">
    <div class="vch-in mb-3 flex flex-wrap items-center justify-between gap-3">
      <div class="flex items-center gap-3">
        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl text-white {{ $isEdit ? 'bg-gradient-to-br from-amber-500 to-orange-500 shadow-lg shadow-amber-500/30' : 'bg-blue-600 shadow-lg shadow-blue-600/30' }}"><i class="fa-solid {{ $isEdit ? 'fa-pen-to-square' : 'fa-receipt' }}" aria-hidden="true"></i></span>
        <div class="min-w-0">
          <h1 class="text-xl font-extrabold tracking-tight text-slate-800">{{ $isEdit ? 'Edit Nota' : 'Buat Nota Barang & Jasa' }}</h1>
          <p class="text-[11px] text-slate-500">{{ $isEdit ? 'Perbarui nota '.$nota->no_nota.'.' : 'No Nota diisi sendiri (unik). Tambah baris barang/jasa.' }}</p>
        </div>
      </div>
      <a href="{{ route('manual-notas.index') }}" class="inline-flex items-center gap-1 rounded-xl bg-white px-3 py-2 text-xs font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-blue-50 hover:text-blue-600"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Kembali</a>
    </div>

    <form method="POST" action="{{ $isEdit ? route('manual-notas.update',$nota) : route('manual-notas.store') }}" id="formNota" class="vch-in max-w-5xl space-y-4 rounded-3xl bg-white/80 p-4 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(37,99,235,.45)] backdrop-blur-xl md:p-5" style="animation-delay:.05s">
@csrf @if($isEdit) @method('PUT') @endif

<p class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-[0.14em] text-blue-600"><i class="fa-solid fa-circle-info" aria-hidden="true"></i> Info Nota</p>
<div class="grid md:grid-cols-3 gap-3">
  <label class="block text-sm font-medium text-slate-600">No Nota* <input name="no_nota" value="{{ old('no_nota', $isEdit ? $nota->no_nota : $suggestedNo) }}" required placeholder="mis: NOTA-001 / INV/10/2026/01" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100 font-mono font-bold"></label>
  <label class="block text-sm font-medium text-slate-600">Tanggal* <input type="date" name="tanggal" value="{{ old('tanggal', $isEdit ? $nota->tanggal->format('Y-m-d') : date('Y-m-d')) }}" required class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"></label>
  <label class="block text-sm font-medium text-slate-600">Jatuh Tempo <input type="date" name="jatuh_tempo" value="{{ old('jatuh_tempo', $isEdit && $nota->jatuh_tempo ? $nota->jatuh_tempo->format('Y-m-d') : '') }}" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"><span class="text-[11px] text-slate-400">Kosongkan jika tunai</span></label>
</div>

<p class="flex items-center gap-1.5 pt-1 text-[10px] font-bold uppercase tracking-[0.14em] text-blue-600"><i class="fa-solid fa-user" aria-hidden="true"></i> Pelanggan</p>
<div class="grid md:grid-cols-3 gap-3">
  <label class="block text-sm font-medium text-slate-600">Pelanggan* <input name="pelanggan_nama" value="{{ old('pelanggan_nama', $isEdit ? $nota->pelanggan_nama : (isset($duplicate)?$duplicate->pelanggan_nama:'')) }}" required placeholder="Nama pelanggan / toko" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"></label>
  <label class="block text-sm font-medium text-slate-600">No HP <input name="pelanggan_hp" value="{{ old('pelanggan_hp', $isEdit ? $nota->pelanggan_hp : (isset($duplicate)?$duplicate->pelanggan_hp:'')) }}" placeholder="08xx" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"></label>
  <label class="block text-sm font-medium text-slate-600">Metode Bayar <select name="metode_bayar" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"><option value="">-- pilih --</option><option value="tunai" {{ old('metode_bayar', $isEdit?$nota->metode_bayar:'')=='tunai'?'selected':'' }}>Tunai</option><option value="transfer" {{ old('metode_bayar', $isEdit?$nota->metode_bayar:'')=='transfer'?'selected':'' }}>Transfer</option><option value="qris" {{ old('metode_bayar', $isEdit?$nota->metode_bayar:'')=='qris'?'selected':'' }}>QRIS</option><option value="lain" {{ old('metode_bayar', $isEdit?$nota->metode_bayar:'')=='lain'?'selected':'' }}>Lain</option></select></label>
</div>
<label class="block text-sm font-medium text-slate-600">Alamat Pelanggan <textarea name="pelanggan_alamat" rows="2" placeholder="Opsional" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">{{ old('pelanggan_alamat', $isEdit ? $nota->pelanggan_alamat : (isset($duplicate)?$duplicate->pelanggan_alamat:'')) }}</textarea></label>

<div class="overflow-hidden rounded-2xl ring-1 ring-slate-200">
  <div class="flex items-center justify-between gap-2 bg-blue-600 px-3 py-2.5 text-white">
    <span class="flex items-center gap-1.5 text-sm font-semibold"><i class="fa-solid fa-list text-white/80" aria-hidden="true"></i> Rincian Barang & Jasa</span>
    <button type="button" id="btnAddRow" class="inline-flex items-center gap-1 rounded-lg bg-white/20 px-3 py-1.5 text-xs font-bold ring-1 ring-white/30 backdrop-blur transition hover:bg-white/30"><i class="fa-solid fa-plus" aria-hidden="true"></i> Baris</button>
  </div>
  <div class="overflow-x-auto">
  <table class="w-full text-sm" id="tblItems">
    <thead class="bg-slate-50/80 text-[11px] uppercase tracking-wide text-slate-400"><tr><th class="px-2 py-2 text-left w-[28%]">Nama*</th><th class="px-2 py-2 w-[12%]">Kategori</th><th class="px-2 py-2 w-[10%]">Qty</th><th class="px-2 py-2 w-[10%]">Satuan</th><th class="px-2 py-2 w-[16%]">Harga</th><th class="px-2 py-2 w-[12%]">Diskon</th><th class="px-2 py-2 w-[14%]">Subtotal</th><th class="px-1 py-2"></th></tr></thead>
    <tbody id="tbodyItems"></tbody>
  </table>
  </div>
    <div class="border-t border-slate-100 bg-slate-50/80 px-3 py-2 text-[11px] text-slate-400">Kategori untuk badge di cetak. Diskon per baris opsional.</div>
</div>

<div class="grid md:grid-cols-3 gap-3">
  <label class="block text-sm font-medium text-slate-600">Diskon Global <div class="flex gap-1 mt-1"><select name="diskon_tipe" id="diskon_tipe" class="w-[42%] rounded-xl border border-slate-200 bg-white px-2 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"><option value="">Tanpa</option><option value="nominal" {{ old('diskon_tipe', $isEdit?$nota->diskon_tipe:'')=='nominal'?'selected':'' }}>Nominal</option><option value="persen" {{ old('diskon_tipe', $isEdit?$nota->diskon_tipe:'')=='persen'?'selected':'' }}>Persen</option></select><input type="number" step="0.01" min="0" name="diskon_nilai" id="diskon_nilai" value="{{ old('diskon_nilai', $isEdit? $nota->diskon_nilai : 0) }}" class="min-w-0 flex-1 rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100" placeholder="0"></div></label>
  <label class="block text-sm font-medium text-slate-600">Biaya Lain <div class="flex gap-1 mt-1"><input type="text" name="biaya_lain_label" value="{{ old('biaya_lain_label', $isEdit?$nota->biaya_lain_label:'') }}" placeholder="Ongkir" class="w-[40%] rounded-xl border border-slate-200 bg-white px-2 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"><input type="number" step="0.01" min="0" name="biaya_lain" id="biaya_lain" value="{{ old('biaya_lain', $isEdit? $nota->biaya_lain : 0) }}" class="min-w-0 flex-1 rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100" placeholder="0"></div></label>
    <div class="rounded-2xl bg-blue-50 p-3 ring-1 ring-blue-100">
      <div class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-[0.14em] text-blue-600"><i class="fa-solid fa-calculator" aria-hidden="true"></i> Ringkasan</div>
      <div class="mt-1 text-xs text-slate-600" id="previewRincian">-</div>
      <div class="mt-1 bg-blue-600 bg-clip-text text-xl font-extrabold text-transparent tabular-nums" id="previewTotal">Rp 0</div>
      <div class="text-xs" id="previewSisa"></div>
    </div>
</div>

<p class="flex items-center gap-1.5 pt-1 text-[10px] font-bold uppercase tracking-[0.14em] text-blue-600"><i class="fa-solid fa-wallet" aria-hidden="true"></i> Pembayaran & Keterangan</p>
<div class="grid md:grid-cols-2 gap-3">
  <div class="space-y-3">
    <label class="block text-sm font-medium text-slate-600">Status Pembayaran*
      <div class="mt-1 flex flex-wrap gap-2">
        <label class="flex flex-1 cursor-pointer items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2.5 transition has-[:checked]:border-emerald-300 has-[:checked]:bg-emerald-50 has-[:checked]:ring-2 has-[:checked]:ring-emerald-100"><input type="radio" name="status" value="lunas" {{ old('status', $isEdit?$nota->status:'belum_lunas')=='lunas'?'checked':'' }} required> <span class="text-sm font-semibold text-emerald-700">Lunas</span></label>
        <label class="flex flex-1 cursor-pointer items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2.5 transition has-[:checked]:border-rose-300 has-[:checked]:bg-rose-50 has-[:checked]:ring-2 has-[:checked]:ring-rose-100"><input type="radio" name="status" value="belum_lunas" {{ old('status', $isEdit?$nota->status:'belum_lunas')=='belum_lunas'?'checked':'' }} required> <span class="text-sm font-semibold text-rose-700">Belum Lunas</span></label>
        <label class="flex flex-1 cursor-pointer items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2.5 transition has-[:checked]:border-amber-300 has-[:checked]:bg-amber-50 has-[:checked]:ring-2 has-[:checked]:ring-amber-100"><input type="radio" name="status" value="dp" {{ old('status', $isEdit?$nota->status:'')=='dp'?'checked':'' }} required> <span class="text-sm font-semibold text-amber-700">DP</span></label>
      </div>
    </label>
    <label class="block text-sm font-medium text-slate-600" id="wrapDp">DP Dibayar (Rp)* <input type="number" step="0.01" min="0" name="dp_nominal" id="dp_nominal" value="{{ old('dp_nominal', $isEdit? $nota->dp_nominal : 0) }}" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100" placeholder="0"> <span class="text-[11px] text-slate-400">Wajib jika DP, max = total</span></label>
  </div>
  <div class="space-y-3">
    <label class="block text-sm font-medium text-slate-600">Keterangan <textarea name="keterangan" rows="2" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100" placeholder="Catatan internal">{{ old('keterangan', $isEdit?$nota->keterangan:'') }}</textarea></label>
    <label class="block text-sm font-medium text-slate-600">Catatan Footer Nota <input name="catatan_nota" value="{{ old('catatan_nota', $isEdit?$nota->catatan_nota:'Terima kasih atas kepercayaan Anda') }}" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"></label>
  </div>
</div>

    <div class="flex flex-wrap items-center gap-2 border-t border-slate-100 pt-3">
      <button class="inline-flex items-center gap-1.5 rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-600/25 transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2"><i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> {{ $isEdit ? 'Update Nota' : 'Simpan Nota' }}</button>
      <a href="{{ route('manual-notas.index') }}" class="inline-flex items-center rounded-xl bg-white px-6 py-2.5 text-sm font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-slate-50">Batal</a>
      @if(!$isEdit)<span class="self-center text-xs text-slate-400">No Nota harus unik</span>@endif
    </div>
    </form>
  </div>
</div>
@push('js')
<script>
const initItems = @json($initItems);
const tbody = document.getElementById('tbodyItems');
const btnAdd = document.getElementById('btnAddRow');
const diskonTipe = document.getElementById('diskon_tipe');
const diskonNilai = document.getElementById('diskon_nilai');
const biayaLain = document.getElementById('biaya_lain');
const dpInput = document.getElementById('dp_nominal');
const wrapDp = document.getElementById('wrapDp');
const prevRincian = document.getElementById('previewRincian');
const prevTotal = document.getElementById('previewTotal');
const prevSisa = document.getElementById('previewSisa');
function esc(s){return String(s).replaceAll('&','&amp;').replaceAll('"','&quot;').replaceAll('<','&lt;')}
function rowHtml(i,d){
  return `<tr class="border-t border-slate-100">
    <td class="px-2 py-1"><input name="items[${i}][nama]" value="${esc(d.nama||'')}" required placeholder="Nama barang/jasa" class="w-full rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"></td>
    <td class="px-2 py-1"><select name="items[${i}][kategori]" class="w-full rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"><option value="barang" ${d.kategori=='barang'?'selected':''}>Barang</option><option value="jasa" ${d.kategori=='jasa'?'selected':''}>Jasa</option></select></td>
    <td class="px-2 py-1"><input type="number" step="0.01" min="0.01" name="items[${i}][qty]" value="${d.qty??1}" required class="w-full rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100 qty"></td>
    <td class="px-2 py-1"><input name="items[${i}][satuan]" value="${esc(d.satuan||'pcs')}" required class="w-full rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"></td>
    <td class="px-2 py-1"><input type="number" step="0.01" min="0" name="items[${i}][harga_satuan]" value="${d.harga_satuan??''}" required placeholder="0" class="w-full rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100 harga"></td>
    <td class="px-2 py-1"><input type="number" step="0.01" min="0" name="items[${i}][diskon_item]" value="${d.diskon_item||0}" class="w-full rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100 diskon"></td>
    <td class="px-2 py-1"><div class="text-sm font-bold text-slate-800 sub">Rp 0</div></td>
    <td class="px-1 py-1"><button type="button" onclick="this.closest('tr').remove();recalc()" class="grid h-7 w-7 place-items-center rounded-lg bg-rose-50 text-rose-600 ring-1 ring-rose-100 transition hover:bg-rose-100"><i class="fa-solid fa-xmark text-xs"></i></button></td></tr>`;
}
function render(){
  tbody.innerHTML = initItems.map((d,i)=>rowHtml(i,d)).join('');
  tbody.querySelectorAll('input,select').forEach(el=>el.addEventListener('input', recalc));
  recalc();
}
function recalc(){
  let subtotal=0;
  tbody.querySelectorAll('tr').forEach(tr=>{
    const q=parseFloat(tr.querySelector('.qty')?.value||0),h=parseFloat(tr.querySelector('.harga')?.value||0),d=parseFloat(tr.querySelector('.diskon')?.value||0);
    let line=q*h-d; if(line<0) line=0; subtotal+=line;
    tr.querySelector('.sub').textContent='Rp '+line.toLocaleString('id-ID');
  });
  let disc=0; const tipe=diskonTipe.value, val=parseFloat(diskonNilai.value||0);
  if(tipe==='persen'&&val>0) disc=subtotal*val/100; else if(tipe==='nominal') disc=val;
  if(disc>subtotal) disc=subtotal;
  const biaya=parseFloat(biayaLain.value||0);
  let total=subtotal-disc+biaya; if(total<0) total=0;
  const status=document.querySelector('input[name=status]:checked')?.value||'belum_lunas';
  let dp=parseFloat(dpInput.value||0); if(dp>total) dp=total;
  let sisa=total;
  if(status==='lunas'){sisa=0; dp=0;} else if(status==='dp'){sisa=total-dp;}
  prevRincian.innerHTML=`Subtotal Rp ${subtotal.toLocaleString('id-ID')}<br>Diskon Rp ${disc.toLocaleString('id-ID')} + Biaya Rp ${biaya.toLocaleString('id-ID')}`;
  prevTotal.textContent='Total Rp '+total.toLocaleString('id-ID');
  if(status==='dp') prevSisa.innerHTML=`<span class="text-amber-700 font-semibold">DP Rp ${dp.toLocaleString('id-ID')} — Sisa Rp ${sisa.toLocaleString('id-ID')}</span>`;
  else if(status==='belum_lunas') prevSisa.innerHTML=`<span class="text-rose-600 font-semibold">Sisa Rp ${sisa.toLocaleString('id-ID')}</span>`;
  else prevSisa.innerHTML=`<span class="text-emerald-700 font-semibold">LUNAS</span>`;
  wrapDp.style.display=status==='dp'?'block':'none';
  if(status!=='dp') dpInput.value=0;
}
btnAdd.addEventListener('click',()=>{
  const i=tbody.querySelectorAll('tr').length;
  tbody.insertAdjacentHTML('beforeend', rowHtml(i,{nama:'',kategori:'barang',qty:1,satuan:'pcs',harga_satuan:'',diskon_item:0}));
  tbody.lastElementChild.querySelectorAll('input,select').forEach(el=>el.addEventListener('input', recalc));
  recalc();
});
[diskonTipe,diskonNilai,biayaLain,dpInput].forEach(el=>el.addEventListener('input', recalc));
document.querySelectorAll('input[name=status]').forEach(r=>r.addEventListener('change', recalc));
document.getElementById('formNota').addEventListener('submit', e=>{
  const rows=tbody.querySelectorAll('tr').length;
  if(rows===0){e.preventDefault();alert('Tambah minimal 1 baris');return;}
  let has=false; tbody.querySelectorAll('tr').forEach(tr=>{if(tr.querySelector('input[name*=\"[nama]\"]')?.value.trim()) has=true;});
  if(!has){e.preventDefault();alert('Isi nama barang/jasa');return;}
  const st=document.querySelector('input[name=status]:checked')?.value;
  if(st==='dp'&&parseFloat(dpInput.value||0)<=0){e.preventDefault();alert('DP wajib diisi saat status DP');}
});
render();
</script>
@endpush
@endsection