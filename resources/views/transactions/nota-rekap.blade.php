<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Rekap {{ $reseller->nama }} - Nota</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>*{font-family:Inter,sans-serif} @page{size:A5 portrait;margin:10mm} *{-webkit-print-color-adjust:exact;print-color-adjust:exact} @media print{.no-print{display:none !important}}</style>
</head>
<body class="bg-slate-100 p-3 md:p-6">
<div class="no-print max-w-[460px] mx-auto mb-3 flex gap-2">
  <button onclick="window.print()" class="flex-1 rounded-xl bg-blue-600 py-2.5 font-semibold text-white shadow-lg shadow-blue-600/25 transition hover:brightness-110">Cetak Nota</button>
  <a href="{{ route('transactions.rekap', request()->only(['dari','sampai','status','voucher_type'])) }}" class="rounded-xl bg-white px-4 py-2.5 text-sm text-slate-600 ring-1 ring-slate-200 transition hover:bg-blue-50 hover:text-blue-600">Kembali</a>
</div>
<div class="max-w-[460px] mx-auto bg-white p-4 md:p-5 shadow border print:shadow-none">
  <div class="text-center border-b-2 border-slate-800 pb-3 mb-3">
    <div class="flex justify-center mb-2"><img src="{{ ($company ?? null) ? $company->logoUrl() : asset('logo.png') }}" alt="{{ ($company->name ?? 'Datanet') }}" class="h-10 object-contain"></div>
    <div class="font-bold text-lg tracking-tight text-[#1b2d4a]">{{ strtoupper($company->name ?? 'DATANET') }}</div>
    @if(!empty($company->address))<div class="text-[10px] text-slate-500">{{ $company->address }}</div>@endif
    @if(!empty($company->phone))<div class="text-[10px] text-slate-500">{{ $company->phone }}</div>@endif
    @if(!empty($company->email))<div class="text-[10px] text-slate-500">{{ $company->email }}</div>@endif
    <div class="text-xs font-semibold mt-2 tracking-wide">REKAP VOUCHER PER RESELLER</div>
  </div>
  <div class="text-xs space-y-1 mb-3">
    <div class="flex justify-between"><span class="text-slate-500">No Rekap</span><span class="font-mono font-bold">RKP-{{ str_pad($reseller->id,4,'0',STR_PAD_LEFT) }}-{{ now()->format('ymd') }}</span></div>
    <div class="flex justify-between"><span class="text-slate-500">Tanggal Cetak</span><span class="font-semibold">{{ now()->translatedFormat('d F Y H:i') }}</span></div>
    @if($periode)<div class="flex justify-between"><span class="text-slate-500">Periode</span><span class="font-semibold">{{ $periode }}</span></div>@endif
    @if(request('status'))<div class="flex justify-between"><span class="text-slate-500">Filter</span><span class="font-semibold">{{ request('status')=='lunas'?'Lunas':'Belum Lunas' }}</span></div>@endif
  </div>
  <div class="bg-slate-50 border rounded-xl p-3 mb-3 text-xs">
    <div class="font-bold text-sm text-[#1b2d4a]">{{ $reseller->nama }}</div>
    @if($reseller->no_hp)<div class="text-slate-600">HP: {{ $reseller->no_hp }}</div>@endif
    @if($reseller->alamat)<div class="text-slate-500">{{ $reseller->alamat }}</div>@endif
  </div>
  @php $totalQty=(int)($aggr->total_qty??0); $piutang=(float)($aggr->piutang??0); $lunas=(float)($aggr->lunas??0); $totalNom=(float)($aggr->total_nominal??0); $trx=(int)($aggr->trx_count??0); @endphp
  @if($trx==0)
    <div class="border rounded-xl p-6 text-center text-sm text-slate-400">Tidak ada order pada periode ini</div>
  @else
  <div class="border rounded-xl overflow-hidden mb-3">
    <div class="bg-slate-900 text-white px-3 py-2 text-xs font-semibold flex justify-between"><span>Ringkasan Total Order</span><span class="bg-white/20 px-2 py-0.5 rounded-full">{{ $trx }} TRX</span></div>
    <table class="w-full text-xs">
      <thead class="bg-slate-50 text-slate-500"><tr><th class="px-3 py-2 text-left">Vocer</th><th class="px-2 py-2 text-center">Qty</th><th class="px-2 py-2 text-right">Harga</th><th class="px-3 py-2 text-right">Subtotal</th></tr></thead>
      <tbody class="text-sm">
        <tr class="border-t"><td class="px-3 py-2">3.000</td><td class="px-2 py-2 text-center {{ (int)$aggr->qty_3k==0?'text-slate-300':'' }}">{{ (int)$aggr->qty_3k ?: '-' }}</td><td class="px-2 py-2 text-right">2.500</td><td class="px-3 py-2 text-right">Rp {{ number_format((int)$aggr->qty_3k*2500,0,',','.') }}</td></tr>
        <tr class="border-t"><td class="px-3 py-2">5.000</td><td class="px-2 py-2 text-center {{ (int)$aggr->qty_5k==0?'text-slate-300':'' }}">{{ (int)$aggr->qty_5k ?: '-' }}</td><td class="px-2 py-2 text-right">4.000</td><td class="px-3 py-2 text-right">Rp {{ number_format((int)$aggr->qty_5k*4000,0,',','.') }}</td></tr>
        <tr class="border-t"><td class="px-3 py-2">10.000</td><td class="px-2 py-2 text-center {{ (int)$aggr->qty_10k==0?'text-slate-300':'' }}">{{ (int)$aggr->qty_10k ?: '-' }}</td><td class="px-2 py-2 text-right">9.000</td><td class="px-3 py-2 text-right">Rp {{ number_format((int)$aggr->qty_10k*9000,0,',','.') }}</td></tr>
      </tbody>
      <tfoot class="bg-slate-900 text-white font-bold"><tr><td class="px-3 py-2" colspan="2">TOTAL {{ $totalQty }} pcs</td><td class="px-3 py-2 text-right" colspan="2">Rp {{ number_format($totalNom,0,',','.') }}</td></tr></tfoot>
    </table>
  </div>
  <div class="grid grid-cols-2 gap-2 mb-3 text-xs">
    <div class="bg-red-50 border border-red-200 rounded-xl p-2.5 text-center"><div class="text-[10px] font-bold text-red-600 tracking-widest">PIUTANG</div><div class="font-bold text-red-700 mt-1">Rp {{ number_format($piutang,0,',','.') }}</div><div class="text-[10px] text-red-600">Belum Lunas</div></div>
    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-2.5 text-center"><div class="text-[10px] font-bold text-emerald-700 tracking-widest">LUNAS</div><div class="font-bold text-emerald-700 mt-1">Rp {{ number_format($lunas,0,',','.') }}</div><div class="text-[10px] text-emerald-600">Sudah Dibayar</div></div>
  </div>
  @if($details->isNotEmpty())
  <div class="border rounded-xl overflow-hidden mb-3">
    <div class="bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-600 flex justify-between">
      <span>Rekap Total Transaksi per Tanggal</span>
      <span>{{ $details->count() }} Hari</span>
    </div>
    <table class="w-full text-[11px]">
      <thead class="bg-slate-50 text-slate-500">
        <tr>
          <th class="px-2 py-1.5 text-left">Tanggal</th>
          <th class="px-2 py-1.5 text-center">3k</th>
          <th class="px-2 py-1.5 text-center">5k</th>
          <th class="px-2 py-1.5 text-center">10k</th>
          <th class="px-2 py-1.5 text-right">Total Nom.</th>
          <th class="px-2 py-1.5 text-center">Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($details as $d)
        <tr class="border-t">
          <td class="px-2 py-1.5 whitespace-nowrap font-medium">{{ $d->tanggal->format('d/m/y') }}</td>
          <td class="px-2 py-1.5 text-center {{ $d->qty_3k == 0 ? 'text-slate-300' : '' }}">{{ $d->qty_3k ?: '-' }}</td>
          <td class="px-2 py-1.5 text-center {{ $d->qty_5k == 0 ? 'text-slate-300' : '' }}">{{ $d->qty_5k ?: '-' }}</td>
          <td class="px-2 py-1.5 text-center {{ $d->qty_10k == 0 ? 'text-slate-300' : '' }}">{{ $d->qty_10k ?: '-' }}</td>
          <td class="px-2 py-1.5 text-right font-semibold">Rp {{ number_format($d->nominal,0,',','.') }}</td>
          <td class="px-2 py-1.5 text-center">
            @if($d->is_all_lunas)
              <span class="bg-emerald-100 text-emerald-700 px-1.5 py-0.5 rounded text-[10px] font-bold">LUNAS</span>
            @elseif($d->is_all_belum)
              <span class="bg-red-100 text-red-700 px-1.5 py-0.5 rounded text-[10px] font-bold">BELUM</span>
            @else
              <span class="bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded text-[10px] font-bold" title="Campuran (Lunas & Belum)">CAMPUR</span>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
  @endif
  <div class="flex justify-between text-xs mt-4">
    <div class="text-center"><div class="mb-8 text-slate-500">Penerima</div><div class="border-t pt-1 px-6">{{ $reseller->nama }}</div></div>
    <div class="text-center"><div class="mb-8 text-slate-500">{{ ($company->pimpinan_jabatan ?? 'Admin') }}</div><div class="border-t pt-1 px-6">{{ ($company->pimpinan_nama ?? $company->name ?? 'Datanet') }}</div></div>
  </div>
  <div class="text-center text-[10px] text-slate-400 mt-4 border-t pt-2">Dicetak: {{ now()->translatedFormat('d/m/Y H:i') }} | Simpan nota ini sebagai bukti rekap</div>
</div>
<script>window.onload=()=>setTimeout(()=>window.print(),400)</script>
</body>
</html>
