@extends('layouts.app')
@section('title','Generate Gaji')
@section('content')
<h1 class="text-lg font-bold mb-1">Generate Gaji Bulanan</h1>
<p class="text-sm text-slate-500 mb-2">Rumus: <strong>Gaji Pokok + (Hadir x Bonus/Hadir) + Insentif Klien Baru + Lembur - Potongan</strong>. Insentif hanya dari Klien Baru, bukan voucher.</p>
<div class="bg-amber-50 border border-amber-200 text-amber-800 text-xs rounded-xl px-3 py-2 mb-3"><i class="fa-solid fa-rotate mr-1"></i> <strong>Generate boleh berkali-kali</strong> untuk periode yang sama &mdash; klik Generate lagi akan <strong>update</strong> slip (bukan duplikat). Ubah nominal/jam/catatan lembur lalu Generate lagi untuk koreksi. Isi <code>0</code> atau kosongkan untuk menghapus lembur.</div>
<form method="GET" action="{{ route('payrolls.create') }}" class="bg-white p-3 rounded-2xl shadow-sm border mb-3 flex flex-wrap gap-2 items-end">
  <label class="text-sm">Bulan<select name="bulan" class="ml-1 border rounded-xl px-2 py-2 text-sm">@for($m=1;$m<=12;$m++)<option value="{{ $m }}" {{ (int)$bulan==$m?'selected':'' }}>{{ DateTime::createFromFormat('!m',$m)->format('F') }}</option>@endfor</select></label>
  <label class="text-sm">Tahun<select name="tahun" class="ml-1 border rounded-xl px-2 py-2 text-sm">@for($y=now()->year-1;$y<=now()->year+1;$y++)<option value="{{ $y }}" {{ (int)$tahun==$y?'selected':'' }}>{{ $y }}</option>@endfor</select></label>
  <button class="bg-slate-800 text-white px-4 py-2 rounded-xl text-sm">Preview</button>
</form>
<form method="POST" action="{{ route('payrolls.store') }}">
@csrf
<input type="hidden" name="periode_bulan" value="{{ $bulan }}">
<input type="hidden" name="periode_tahun" value="{{ $tahun }}">
<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-sm">
<thead class="bg-slate-50 text-xs text-slate-500"><tr><th class="px-2 py-2"><input type="checkbox" id="checkAll" checked></th><th class="px-2 py-2 text-left">Karyawan</th><th class="px-2 py-2 text-right">Pokok</th><th class="px-2 py-2 text-center">Hadir</th><th class="px-2 py-2 text-right">Bonus</th><th class="px-2 py-2 text-right">Insentif</th><th class="px-2 py-2 text-right">Potongan</th><th class="px-2 py-2 text-center bg-blue-50">Lembur <span class="font-normal">(jam / Rp / cat.)</span></th><th class="px-2 py-2 text-right">Terima</th><th class="px-2 py-2">Status</th></tr></thead>
<tbody>
@foreach($preview as $pr)
@php $e=$pr['employee']; $rowTerima=$pr['total_terima']; @endphp
<tr class="border-t hover:bg-slate-50">
  <td class="px-2 py-2 text-center align-top"><input type="checkbox" name="employee_ids[]" value="{{ $e->id }}" checked class="chk"></td>
  <td class="px-2 py-2 align-top"><div class="font-semibold">{{ $e->nama }}</div><div class="text-xs text-slate-500">{{ $e->jabatan }} | Rp {{ number_format($e->gaji_pokok,0,',','.') }}</div>@if($pr['insentif_list']->count())<div class="text-[11px] text-emerald-600">{{ $pr['insentif_list']->count() }} klien baru</div>@endif</td>
  <td class="px-2 py-2 text-right align-top">Rp {{ number_format($pr['gaji_pokok'],0,',','.') }}</td>
  <td class="px-2 py-2 text-center align-top"><span class="bg-sky-100 text-sky-700 px-2 py-1 rounded-full text-xs whitespace-nowrap">{{ $pr['jml_hadir'] }} x Rp {{ number_format($e->bonus_per_hadir,0,',','.') }}</span></td>
  <td class="px-2 py-2 text-right text-emerald-600 align-top">+Rp {{ number_format($pr['bonus_kehadiran'],0,',','.') }}</td>
  <td class="px-2 py-2 text-right text-sky-600 align-top">+Rp {{ number_format($pr['total_insentif'],0,',','.') }}</td>
  <td class="px-2 py-2 text-right text-red-600 align-top">-Rp {{ number_format($pr['total_potongan'],0,',','.') }}</td>
  <td class="px-2 py-2 align-top bg-blue-50/40">
    <div class="flex gap-1 items-center">
      <input type="number" step="0.5" min="0" max="744" name="overtime_jam[{{ $e->id }}]" value="{{ $pr['oJam'] ?? 0 }}" placeholder="jam" class="o-jam border rounded-lg px-2 py-1.5 text-xs w-16" title="Jam lembur">
      <input type="number" step="1000" min="0" max="999999999" name="overtime_nominal[{{ $e->id }}]" value="{{ $pr['oNom'] ?? 0 }}" placeholder="Rp" class="o-nom border rounded-lg px-2 py-1.5 text-xs w-28" title="Nominal lembur Rp">
    </div>
    <input type="text" maxlength="255" name="overtime_catatan[{{ $e->id }}]" value="{{ $pr['oCat'] ?? '' }}" placeholder="catatan lembur (opsional)" class="mt-1 border rounded-lg px-2 py-1.5 text-xs w-full" title="Catatan lembur">
    <div class="text-[11px] text-blue-600 mt-0.5">+Rp <span class="o-preview">{{ number_format($pr['oNom'] ?? 0,0,',','.') }}</span> @if(($pr['oCat'] ?? '')!=='')<span class="text-slate-500">&mdash; {{ $pr['oCat'] }}</span>@endif</div>
  </td>
  <td class="px-2 py-2 text-right font-bold align-top"><span class="row-terima" data-base="{{ $pr['gaji_pokok']+$pr['bonus_kehadiran']+$pr['total_insentif']-$pr['total_potongan'] }}">Rp {{ number_format($rowTerima,0,',','.') }}</span></td>
  <td class="px-2 py-2 text-center align-top">@if($pr['existing'])<span class="bg-amber-100 text-amber-700 px-2 py-1 rounded-full text-xs">Sudah ada</span>@else<span class="bg-slate-100 text-slate-600 px-2 py-1 rounded-full text-xs">Baru</span>@endif</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
<div class="mt-3 flex gap-2">
  <button class="bg-sky-600 text-white px-6 py-2.5 rounded-xl font-semibold">Generate / Update Terpilih</button>
  <a href="{{ route('payrolls.index',['bulan'=>$bulan,'tahun'=>$tahun]) }}" class="px-6 py-2.5 border bg-white rounded-xl">Lihat Payroll Periode Ini</a>
</div>
</form>
@push('js')
<script>
document.getElementById('checkAll').addEventListener('change',e=>document.querySelectorAll('.chk').forEach(c=>c.checked=e.target.checked));
document.querySelectorAll('.o-nom').forEach(inp=>{
  inp.addEventListener('input',()=>{
    const tr=inp.closest('tr');
    const base=parseFloat(tr.querySelector('.row-terima').dataset.base)||0;
    const nom=parseFloat(inp.value)||0;
    tr.querySelector('.row-terima').textContent='Rp '+(base+nom).toLocaleString('id-ID');
    tr.querySelector('.o-preview').textContent=nom.toLocaleString('id-ID');
  });
});
</script>
@endpush
@endsection
