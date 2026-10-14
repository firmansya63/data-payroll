<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Slip Gaji - {{ $payroll->employee->nama }} {{ str_pad($payroll->periode_bulan,2,'0',STR_PAD_LEFT) }}/{{ $payroll->periode_tahun }}</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>*{font-family:Inter,sans-serif} @media print{.no-print{display:none !important} @page{size:A5 portrait; margin:10mm} body{-webkit-print-color-adjust:exact; print-color-adjust:exact}}</style>
</head>
<body class="bg-slate-100 p-3 md:p-6">
<div class="no-print max-w-[460px] mx-auto mb-3 flex gap-2">
  <button onclick="window.print()" class="flex-1 bg-[#1b2d4a] text-white py-2.5 rounded-xl font-semibold">Cetak Slip Gaji</button>
  <a href="{{ route('payrolls.index',['bulan'=>$payroll->periode_bulan,'tahun'=>$payroll->periode_tahun]) }}" class="px-4 py-2.5 border bg-white rounded-xl text-sm">Kembali</a>
</div>
<div class="max-w-[460px] mx-auto bg-white p-4 md:p-5 shadow border print:shadow-none">
  <div class="text-center border-b-2 border-slate-800 pb-4 mb-4">
    @php $c = $company ?? null; @endphp
    <div class="flex justify-center mb-2"><img src="{{ $c ? $c->logoUrl() : asset('logo.png') }}" alt="{{ $c ? $c->name : 'Datanet' }}" class="h-10 object-contain"></div>
    <div class="font-bold text-lg tracking-wide text-[#1b2d4a]">{{ strtoupper($c ? $c->name : 'DATANET') }}</div>
    @if($c && $c->tagline)<div class="text-xs text-slate-500">{{ $c->tagline }}</div>@endif
    <div class="text-xs text-slate-500">@if($c && $c->address){{ $c->address }}@else Jl. Contoh No. 123 Kec. Contoh Kab. Contoh @endif @if($c && $c->phone) - Telp. {{ $c->phone }} @endif @if($c && $c->email) - {{ $c->email }} @endif</div>
    <div class="inline-block mt-2 border-2 border-slate-800 px-6 py-1 font-bold text-sm tracking-widest">SLIP GAJI KARYAWAN</div>
    <div class="text-xs mt-1 font-semibold">Periode: {{ DateTime::createFromFormat('!m',$payroll->periode_bulan)->format('F') }} {{ $payroll->periode_tahun }}</div>
  </div>
  <div class="grid grid-cols-2 gap-4 text-sm mb-4 bg-slate-50 p-3 rounded-xl">
    <div>
      <div class="flex justify-between"><span class="text-slate-500 w-24">Nama</span><span class="font-semibold">: {{ $payroll->employee->nama }}</span></div>
      <div class="flex justify-between"><span class="text-slate-500 w-24">Jabatan</span><span class="font-semibold">: {{ ucfirst($payroll->employee->jabatan) }}</span></div>
      <div class="flex justify-between"><span class="text-slate-500 w-24">No HP</span><span class="font-semibold">: {{ $payroll->employee->no_hp ?? '-' }}</span></div>
    </div>
    <div>
      <div class="flex justify-between"><span class="text-slate-500 w-20">No Slip</span><span class="font-mono">: #{{ str_pad($payroll->id,6,'0',STR_PAD_LEFT) }}</span></div>
      <div class="flex justify-between"><span class="text-slate-500 w-20">Periode</span><span class="font-semibold">: {{ str_pad($payroll->periode_bulan,2,'0',STR_PAD_LEFT) }}/{{ $payroll->periode_tahun }}</span></div>
      <div class="flex justify-between"><span class="text-slate-500 w-20">Cetak</span><span class="font-semibold">: {{ now()->format('d/m/Y') }}</span></div>
    </div>
  </div>
  <table class="w-full text-sm border">
    <thead class="bg-[#1b2d4a] text-white"><tr><th class="px-3 py-2 text-left">No</th><th class="px-3 py-2 text-left">Uraian</th><th class="px-3 py-2 text-right">Nominal (Rp)</th></tr></thead>
    <tbody>
      <tr class="border-b"><td class="px-3 py-2">1</td><td class="px-3 py-2">Gaji Pokok</td><td class="px-3 py-2 text-right font-semibold">Rp {{ number_format($payroll->gaji_pokok,0,',','.') }}</td></tr>
      <tr class="border-b"><td class="px-3 py-2">2</td><td class="px-3 py-2">Bonus Kehadiran<br><span class="text-xs text-slate-500">{{ $payroll->jml_hadir }} hari x Rp {{ number_format($payroll->employee->bonus_per_hadir,0,',','.') }}</span></td><td class="px-3 py-2 text-right font-semibold text-emerald-600">+ Rp {{ number_format($payroll->bonus_kehadiran,0,',','.') }}</td></tr>
      <tr class="border-b"><td class="px-3 py-2">3</td><td class="px-3 py-2">Insentif Klien Baru<br><span class="text-xs text-slate-500">{{ $insentifList->count() }} klien berhasil (hanya dari klien baru, bukan voucher)</span></td><td class="px-3 py-2 text-right font-semibold text-sky-600">+ Rp {{ number_format($payroll->total_insentif,0,',','.') }}</td></tr>
      @if($insentifList->count())
      <tr class="bg-sky-50"><td class="px-3 py-1"></td><td class="px-3 py-1 text-xs text-sky-700" colspan="2">@foreach($insentifList as $it)<div class="flex justify-between"><span>- {{ $it->nama_klien }} ({{ $it->tanggal->format('d/m') }})</span><span>Rp {{ number_format($it->nominal_insentif,0,',','.') }}</span></div>@endforeach</td></tr>
      @endif
      <tr class="border-b bg-violet-50"><td class="px-3 py-2">4</td><td class="px-3 py-2">Lembur @if($payroll->jam_lembur>0)<span class="text-xs text-slate-500">({{ rtrim(rtrim(number_format($payroll->jam_lembur,2,',','.'),'0'),',') }} jam)</span>@endif @if($payroll->catatan_lembur)<br><span class="text-xs text-violet-700">{{ $payroll->catatan_lembur }}</span>@endif</td><td class="px-3 py-2 text-right font-semibold text-violet-600">+ Rp {{ number_format($payroll->total_lembur,0,',','.') }}</td></tr>
      <tr class="border-b bg-red-50"><td class="px-3 py-2">5</td><td class="px-3 py-2">Potongan / Kasbon<br><span class="text-xs text-slate-500">{{ $potonganList->count() }} potongan</span></td><td class="px-3 py-2 text-right font-bold text-red-600">- Rp {{ number_format($payroll->total_potongan,0,',','.') }}</td></tr>
      @if($potonganList->count())
      <tr class="bg-red-50"><td class="px-3 py-1"></td><td class="px-3 py-1 text-xs text-red-700" colspan="2">@foreach($potonganList as $p)<div class="flex justify-between"><span>- {{ $p->keterangan ?? 'Potongan' }} ({{ $p->tanggal->format('d/m') }})</span><span>Rp {{ number_format($p->nominal,0,',','.') }}</span></div>@endforeach</td></tr>
      @endif
      <tr class="bg-[#1b2d4a] text-white font-bold text-base"><td class="px-3 py-3" colspan="2">TOTAL</td><td class="px-3 py-3 text-right">Rp {{ number_format($payroll->total_terima,0,',','.') }}</td></tr>
    </tbody>
  </table>
  <div class="flex justify-between text-xs mt-6">
    <div class="text-center"><div class="mb-10 text-slate-500">Penerima</div><div class="border-t pt-1 px-8 font-semibold">{{ $payroll->employee->nama }}</div></div>
    <div class="text-center"><div class="mb-10 text-slate-500">{{ ($company->pimpinan_jabatan ?? 'Admin Keuangan') }}</div><div class="border-t pt-1 px-8">{{ ($company->pimpinan_nama ?? $company->name ?? 'Datanet') }}</div><div class="text-[10px] text-slate-400">{{ now()->translatedFormat('d F Y') }}</div></div>
  </div>
  <div class="text-center text-[10px] text-slate-400 mt-6 border-t pt-2">{{ ($company->footer_text ?? 'Slip ini sah sebagai bukti pembayaran gaji. Simpan dengan baik. Dicetak otomatis oleh sistem '.($company->name ?? 'Datanet').'.') }}</div>
</div>
<script>window.onload=()=>setTimeout(()=>window.print(),500)</script>
</body>
</html>
