<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Nota #{{ $transaction->id }} - {{ $transaction->reseller->nama }}</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>*{font-family:Inter,sans-serif} @media print{.no-print{display:none !important} @page{margin:10mm}}</style>
</head>
<body class="bg-slate-100 p-3 md:p-6">
<div class="no-print max-w-[420px] mx-auto mb-3 flex gap-2">
  <button onclick="window.print()" class="flex-1 bg-[#1b2d4a] text-white py-2.5 rounded-xl font-semibold">Cetak Nota</button>
  <a href="{{ route('transactions.index') }}" class="px-4 py-2.5 border bg-white rounded-xl text-sm">Kembali</a>
</div>
<div class="max-w-[420px] mx-auto bg-white p-5 md:p-6 shadow border print:shadow-none">
  {{-- Header: pakai data Pengaturan Perusahaan (logo, nama, tagline, alamat, HP, email) --}}
  <div class="border-b-2 border-slate-800 pb-3 mb-3">
    <div class="flex items-center gap-3">
      <img src="{{ ($company ?? null) ? $company->logoUrl() : asset('logo.png') }}" alt="{{ $company->name ?? 'Datanet' }}" class="h-12 w-12 object-contain shrink-0">
      <div class="text-left leading-tight">
        <div class="font-bold text-lg tracking-tight text-[#1b2d4a]">{{ strtoupper($company->name ?? 'DATANET') }}</div>
        @if(!empty($company->tagline))<div class="text-[10px] text-slate-500">{{ $company->tagline }}</div>
        @else<div class="text-[10px] text-slate-500">Payroll & Voucher</div>@endif
        @if(!empty($company->address))<div class="text-[10px] text-slate-500 mt-0.5">{{ $company->address }}</div>@endif
        @if(!empty($company->phone))<div class="text-[10px] text-slate-500">{{ $company->phone }}</div>@endif
        @if(!empty($company->email))<div class="text-[10px] text-slate-500">{{ $company->email }}</div>@endif
      </div>
    </div>
    <div class="text-left text-xs font-semibold mt-2">NOTA PENJUALAN VOUCHER</div>
  </div>
  <div class="text-xs space-y-1 mb-3">
    <div class="flex justify-between"><span class="text-slate-500">No Nota</span><span class="font-mono font-bold">#{{ str_pad($transaction->id,6,'0',STR_PAD_LEFT) }}</span></div>
    <div class="flex justify-between"><span class="text-slate-500">Tanggal</span><span class="font-semibold">{{ $transaction->tanggal->translatedFormat('d F Y') }}</span></div>
    <div class="flex justify-between"><span class="text-slate-500">Reseller</span><span class="font-semibold">{{ $transaction->reseller->nama }}</span></div>
    @if($transaction->reseller->no_hp)<div class="flex justify-between"><span class="text-slate-500">No HP</span><span>{{ $transaction->reseller->no_hp }}</span></div>@endif
  </div>
  <div class="border rounded-xl overflow-hidden mb-3">
    <div class="bg-slate-900 text-white px-3 py-2 flex justify-between items-center text-xs">
      <span class="font-semibold">Rincian Vocer</span>
      @if($transaction->voucher_type)<span class="bg-[#f68b1e] text-white px-2 py-1 rounded-full font-bold">{{ $types[$transaction->voucher_type]['label'] ?? strtoupper($transaction->voucher_type) }}</span>@endif
    </div>
    <div class="p-3 space-y-2 text-sm">
      @if($transaction->voucher_type && $transaction->qty)
        @php $t=$types[$transaction->voucher_type] ?? null; @endphp
        <div class="flex justify-between"><span class="text-slate-500">Jumlah</span><span class="font-bold">{{ $transaction->qty }} pcs</span></div>
        <div class="flex justify-between"><span class="text-slate-500">Harga ke Reseller</span><span>Rp {{ number_format($transaction->harga_satuan,0,',','.') }}/pcs</span></div>
        <div class="flex justify-between"><span class="text-slate-500">Harga Ecer (jual ke pelanggan)</span><span>Rp {{ number_format($transaction->harga_retail,0,',','.') }}/pcs</span></div>
        <div class="flex justify-between text-xs text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-lg px-2 py-1.5"><span>Untung reseller /pcs</span><span class="font-bold">Rp {{ number_format(($transaction->harga_retail - $transaction->harga_satuan),0,',','.') }}</span></div>
        <div class="flex justify-between text-xs text-slate-500"><span>Total ecer ({{ $transaction->qty }} x {{ number_format($transaction->harga_retail,0,',','.') }})</span><span>Rp {{ number_format($transaction->qty * $transaction->harga_retail,0,',','.') }}</span></div>
      @endif
      @if($transaction->keterangan)<div class="pt-2 border-t text-xs text-slate-600"><span class="text-slate-500">Ket:</span> {{ $transaction->keterangan }}</div>@endif
    </div>
  </div>
  <div class="border-y py-3 mb-3">
    <div class="flex justify-between items-center">
      <span class="text-sm text-slate-600">Total Tagihan (ke reseller)</span>
      <span class="text-xl font-bold text-[#1b2d4a]">Rp {{ number_format($transaction->nominal,0,',','.') }}</span>
    </div>
    @if($transaction->voucher_type && $transaction->qty)
    <div class="text-xs text-slate-500 mt-1">{{ $transaction->qty }} x Rp {{ number_format($transaction->harga_satuan,0,',','.') }} = Rp {{ number_format($transaction->nominal,0,',','.') }}</div>
    @endif
  </div>
  @if($transaction->status=='belum_lunas')
  <div class="bg-red-50 border-2 border-red-300 rounded-xl p-3 text-center mb-3">
    <div class="text-xs font-bold text-red-600 tracking-widest">BELUM LUNAS</div>
    <div class="text-sm text-red-700 mt-1">Sisa Tagihan:</div>
    <div class="text-2xl font-bold text-red-700">Rp {{ number_format($transaction->nominal,0,',','.') }}</div>
    <div class="text-xs text-red-600 mt-1">Mohon segera dilunasi. Terima kasih.</div>
  </div>
  @else
  <div class="bg-emerald-50 border-2 border-emerald-300 rounded-xl p-3 text-center mb-3">
    <div class="text-2xl">✅</div>
    <div class="text-sm font-bold text-emerald-700 tracking-widest">L U N A S</div>
    <div class="text-xs text-emerald-600 mt-1">Pembayaran telah diterima. Terima kasih.</div>
  </div>
  @endif
  <div class="flex justify-between text-xs mt-4">
    <div class="text-center"><div class="mb-8 text-slate-500">Penerima</div><div class="border-t pt-1 px-6">{{ $transaction->reseller->nama }}</div></div>
    <div class="text-center"><div class="mb-8 text-slate-500">{{ ($company->pimpinan_jabatan ?? 'Admin') }}</div><div class="border-t pt-1 px-6">{{ ($company->pimpinan_nama ?? $company->name ?? 'Datanet') }}</div></div>
  </div>
  <div class="text-center text-[10px] text-slate-400 mt-4 border-t pt-2">Dicetak: {{ now()->translatedFormat('d/m/Y H:i') }} | Simpan nota ini sebagai bukti</div>
</div>
<script>window.onload=()=>setTimeout(()=>window.print(),400)</script>
</body>
</html>