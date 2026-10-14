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
<h1 class="text-lg font-bold mb-1">{{ $isEdit ? 'Edit Nota' : 'Buat Nota Barang & Jasa' }}</h1>
<p class="text-xs text-slate-500 mb-3">Semua manual untuk keperluan nota. No Nota <b>isi sendiri (unik)</b>. Tambah baris barang/jasa.</p>

<form method="POST" action="{{ $isEdit ? route('manual-notas.update',$nota) : route('manual-notas.store') }}" id="formNota" class="bg-white p-4 rounded-2xl shadow-sm border space-y-4 max-w-5xl">
@csrf @if($isEdit) @method('PUT') @endif

<div class="grid md:grid-cols-3 gap-3">
  <label class="block text-sm">No Nota* <input name="no_nota" value="{{ old('no_nota', $isEdit ? $nota->no_nota : $suggestedNo) }}" required placeholder="mis: NOTA-001 / INV/10/2026/01" class="w-full mt-1 border rounded-xl px-3 py-2.5 text-sm font-mono font-bold"></label>
  <label class="block text-sm">Tanggal* <input type="date" name="tanggal" value="{{ old('tanggal', $isEdit ? $nota->tanggal->format('Y-m-d') : date('Y-m-d')) }}" required class="w-full mt-1 border rounded-xl px-3 py-2.5 text-sm"></label>
  <label class="block text-sm">Jatuh Tempo <input type="date" name="jatuh_tempo" value="{{ old('jatuh_tempo', $isEdit && $nota->jatuh_tempo ? $nota->jatuh_tempo->format('Y-m-d') : '') }}" class="w-full mt-1 border rounded-xl px-3 py-2.5 text-sm"><span class="text-[11px] text-slate-400">Kosongkan jika tunai</span></label>
</div>

<div class="grid md:grid-cols-3 gap-3">
  <label class="block text-sm">Pelanggan* <input name="pelanggan_nama" value="{{ old('pelanggan_nama', $isEdit ? $nota->pelanggan_nama : (isset($duplicate)?$duplicate->pelanggan_nama:'')) }}" required placeholder="Nama pelanggan / toko" class="w-full mt-1 border rounded-xl px-3 py-2.5 text-sm"></label>
  <label class="block text-sm">No HP <input name="pelanggan_hp" value="{{ old('pelanggan_hp', $isEdit ? $nota->pelanggan_hp : (isset($duplicate)?$duplicate->pelanggan_hp:'')) }}" placeholder="08xx" class="w-full mt-1 border rounded-xl px-3 py-2.5 text-sm"></label>
  <label class="block text-sm">Metode Bayar <select name="metode_bayar" class="w-full mt-1 border rounded-xl px-3 py-2.5 text-sm"><option value="">-- pilih --</option><option value="tunai" {{ old('metode_bayar', $isEdit?$nota->metode_bayar:'')=='tunai'?'selected':'' }}>Tunai</option><option value="transfer" {{ old('metode_bayar', $isEdit?$nota->metode_bayar:'')=='transfer'?'selected':'' }}>Transfer</option><option value="qris" {{ old('metode_bayar', $isEdit?$nota->metode_bayar:'')=='qris'?'selected':'' }}>QRIS</option><option value="lain" {{ old('metode_bayar', $isEdit?$nota->metode_bayar:'')=='lain'?'selected':'' }}>Lain</option></select></label>
</div>
<label class="block text-sm">Alamat Pelanggan <textarea name="pelanggan_alamat" rows="2" placeholder="Opsional" class="w-full mt-1 border rounded-xl px-3 py-2 text-sm">{{ old('pelanggan_alamat', $isEdit ? $nota->pelanggan_alamat : (isset($duplicate)?$duplicate->pelanggan_alamat:'')) }}</textarea></label>

<div class="border rounded-xl overflow-hidden">
  <div class="bg-slate-900 text-white px-3 py-2.5 flex justify-between items-center">
    <span class="font-semibold text-sm"><i class="fa-solid fa-list mr-1 text-[#f68b1e]"></i> Rincian Barang & Jasa</span>
    <button type="button" id="btnAddRow" class="bg-[#f68b1e] text-white px-3 py-1.5 rounded-lg text-xs font-bold"><i class="fa-solid fa-plus"></i> Baris</button>
  </div>
  <div class="overflow-x-auto">
  <table class="w-full text-sm" id="tblItems">
    <thead class="bg-slate-50 text-xs text-slate-500"><tr><th class="px-2 py-2 text-left w-[28%]">Nama*</th><th class="px-2 py-2 w-[12%]">Kategori</th><th class="px-2 py-2 w-[10%]">Qty</th><th class="px-2 py-2 w-[10%]">Satuan</th><th class="px-2 py-2 w-[16%]">Harga</th><th class="px-2 py-2 w-[12%]">Diskon</th><th class="px-2 py-2 w-[14%]">Subtotal</th><th class="px-1 py-2"></th></tr></thead>
    <tbody id="tbodyItems"></tbody>
  </table>
  </div>
  <div class="bg-slate-50 px-3 py-2 text-xs text-slate-500">Kategori untuk badge di cetak. Diskon per baris opsional.</div>
</div>

<div class="grid md:grid-cols-3 gap-3">
  <label class="block text-sm">Diskon Global <div class="flex gap-1 mt-1"><select name="diskon_tipe" id="diskon_tipe" class="border rounded-xl px-2 py-2.5 text-sm w-[42%]"><option value="">Tanpa</option><option value="nominal" {{ old('diskon_tipe', $isEdit?$nota->diskon_tipe:'')=='nominal'?'selected':'' }}>Nominal</option><option value="persen" {{ old('diskon_tipe', $isEdit?$nota->diskon_tipe:'')=='persen'?'selected':'' }}>Persen</option></select><input type="number" step="0.01" min="0" name="diskon_nilai" id="diskon_nilai" value="{{ old('diskon_nilai', $isEdit? $nota->diskon_nilai : 0) }}" class="flex-1 border rounded-xl px-3 py-2.5 text-sm" placeholder="0"></div></label>
  <label class="block text-sm">Biaya Lain <div class="flex gap-1 mt-1"><input type="text" name="biaya_lain_label" value="{{ old('biaya_lain_label', $isEdit?$nota->biaya_lain_label:'') }}" placeholder="Ongkir" class="border rounded-xl px-2 py-2.5 text-sm w-[40%]"><input type="number" step="0.01" min="0" name="biaya_lain" id="biaya_lain" value="{{ old('biaya_lain', $isEdit? $nota->biaya_lain : 0) }}" class="flex-1 border rounded-xl px-3 py-2.5 text-sm" placeholder="0"></div></label>
  <div class="bg-amber-50 border border-amber-200 rounded-xl p-3">
    <div class="text-xs text-amber-800 font-semibold">Ringkasan</div>
    <div class="text-xs text-slate-600 mt-1" id="previewRincian">-</div>
    <div class="text-lg font-bold text-[#1b2d4a] mt-1" id="previewTotal">Rp 0</div>
    <div class="text-xs" id="previewSisa"></div>
  </div>
</div>

<div class="grid md:grid-cols-2 gap-3">
  <div class="space-y-3">
    <label class="block text-sm">Status Pembayaran*
      <div class="flex gap-2 mt-1">
        <label class="flex-1 border rounded-xl px-3 py-2.5 flex items-center gap-2 cursor-pointer has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-300"><input type="radio" name="status" value="lunas" {{ old('status', $isEdit?$nota->status:'belum_lunas')=='lunas'?'checked':'' }} required> <span class="text-emerald-700 font-semibold text-sm">Lunas</span></label>
        <label class="flex-1 border rounded-xl px-3 py-2.5 flex items-center gap-2 cursor-pointer has-[:checked]:bg-red-50 has-[:checked]:border-red-300"><input type="radio" name="status" value="belum_lunas" {{ old('status', $isEdit?$nota->status:'belum_lunas')=='belum_lunas'?'checked':'' }} required> <span class="text-red-700 font-semibold text-sm">Belum Lunas</span></label>
        <label class="flex-1 border rounded-xl px-3 py-2.5 flex items-center gap-2 cursor-pointer has-[:checked]:bg-amber-50 has-[:checked]:border-amber-300"><input type="radio" name="status" value="dp" {{ old('status', $isEdit?$nota->status:'')=='dp'?'checked':'' }} required> <span class="text-amber-700 font-semibold text-sm">DP</span></label>
      </div>
    </label>
    <label class="block text-sm" id="wrapDp">DP Dibayar (Rp)* <input type="number" step="0.01" min="0" name="dp_nominal" id="dp_nominal" value="{{ old('dp_nominal', $isEdit? $nota->dp_nominal : 0) }}" class="w-full mt-1 border rounded-xl px-3 py-2.5 text-sm" placeholder="0"> <span class="text-[11px] text-slate-400">Wajib jika DP, max = total</span></label>
  </div>
  <div class="space-y-3">
    <label class="block text-sm">Keterangan <textarea name="keterangan" rows="2" class="w-full mt-1 border rounded-xl px-3 py-2 text-sm" placeholder="Catatan internal">{{ old('keterangan', $isEdit?$nota->keterangan:'') }}</textarea></label>
    <label class="block text-sm">Catatan Footer Nota <input name="catatan_nota" value="{{ old('catatan_nota', $isEdit?$nota->catatan_nota:'Terima kasih atas kepercayaan Anda') }}" class="w-full mt-1 border rounded-xl px-3 py-2.5 text-sm"></label>
  </div>
</div>

<div class="flex gap-2 pt-2">
  <button class="bg-[#1b2d4a] hover:bg-[#16233a] text-white px-6 py-2.5 rounded-xl font-semibold text-sm">{{ $isEdit ? 'Update Nota' : 'Simpan Nota' }}</button>
  <a href="{{ route('manual-notas.index') }}" class="px-6 py-2.5 border rounded-xl text-sm">Batal</a>
  @if(!$isEdit)<span class="text-xs text-slate-400 self-center">No Nota harus unik</span>@endif
</div>
</form>
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
  return `<tr class="border-t">
    <td class="px-2 py-1"><input name="items[${i}][nama]" value="${esc(d.nama||'')}" required placeholder="Nama barang/jasa" class="w-full border rounded-lg px-2 py-1.5 text-sm"></td>
    <td class="px-2 py-1"><select name="items[${i}][kategori]" class="w-full border rounded-lg px-2 py-1.5 text-sm"><option value="barang" ${d.kategori=='barang'?'selected':''}>Barang</option><option value="jasa" ${d.kategori=='jasa'?'selected':''}>Jasa</option></select></td>
    <td class="px-2 py-1"><input type="number" step="0.01" min="0.01" name="items[${i}][qty]" value="${d.qty??1}" required class="w-full border rounded-lg px-2 py-1.5 text-sm qty"></td>
    <td class="px-2 py-1"><input name="items[${i}][satuan]" value="${esc(d.satuan||'pcs')}" required class="w-full border rounded-lg px-2 py-1.5 text-sm"></td>
    <td class="px-2 py-1"><input type="number" step="0.01" min="0" name="items[${i}][harga_satuan]" value="${d.harga_satuan??''}" required placeholder="0" class="w-full border rounded-lg px-2 py-1.5 text-sm harga"></td>
    <td class="px-2 py-1"><input type="number" step="0.01" min="0" name="items[${i}][diskon_item]" value="${d.diskon_item||0}" class="w-full border rounded-lg px-2 py-1.5 text-sm diskon"></td>
    <td class="px-2 py-1"><div class="text-sm font-bold sub">Rp 0</div></td>
    <td class="px-1 py-1"><button type="button" onclick="this.closest('tr').remove();recalc()" class="w-7 h-7 grid place-items-center bg-red-50 text-red-600 rounded-lg hover:bg-red-100"><i class="fa-solid fa-xmark text-xs"></i></button></td></tr>`;
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
  else if(status==='belum_lunas') prevSisa.innerHTML=`<span class="text-red-600 font-semibold">Sisa Rp ${sisa.toLocaleString('id-ID')}</span>`;
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