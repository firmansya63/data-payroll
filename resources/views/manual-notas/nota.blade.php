<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Nota {{ $nota->no_nota }} - {{ $nota->pelanggan_nama }}</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>*{font-family:Inter,sans-serif} @page{size:A4 portrait; margin:12mm} @media print{.no-print{display:none!important}} *{-webkit-print-color-adjust:exact;print-color-adjust:exact}</style>
</head>
<body class="bg-slate-100 p-2 md:p-3">
<div class="no-print mx-auto mb-3 flex max-w-[720px] flex-wrap items-center gap-2 rounded-2xl bg-white/80 p-2 ring-1 ring-white/70 shadow-[0_10px_30px_-18px_rgba(37,99,235,.45)] backdrop-blur-xl">
  <button onclick="window.print()" class="inline-flex min-w-[120px] flex-1 items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-600/25 transition hover:brightness-110">Cetak (A4)</button>
  <a href="{{ route('manual-notas.nota-landscape',$nota) }}" class="rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-blue-600 ring-1 ring-blue-200 transition hover:bg-blue-50">↗ A4 Landscape</a>
  <a href="{{ route('manual-notas.index') }}" class="rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-slate-50">Kembali</a>
</div>
<div class="max-w-[720px] mx-auto bg-white p-5 shadow border print:shadow-none print:p-3">
  {{-- Header: logo rata kiri, nama perusahaan di samping logo, alamat & HP di bawah nama --}}
  <div class="border-b-2 border-slate-800 pb-3 mb-3">
    <div class="flex items-center gap-3">
      <img src="{{ ($company ?? null) ? $company->logoUrl() : asset('logo.png') }}" alt="{{ ($company->name ?? 'Datanet') }}" class="h-12 w-12 object-contain shrink-0">
      <div class="text-left leading-tight">
        <div class="font-bold text-lg tracking-tight text-[#1b2d4a]">{{ strtoupper($company->name ?? 'DATANET') }}</div>
        @if(!empty($company->address))<div class="text-[10px] text-slate-500 mt-0.5">{{ $company->address }}</div>@endif
        @if(!empty($company->phone))<div class="text-[10px] text-slate-500">{{ $company->phone }}</div>@endif
        @if(!empty($company->email))<div class="text-[10px] text-slate-500">{{ $company->email }}</div>@endif
      </div>
    </div>
    <div class="text-left text-xs font-semibold mt-2">NOTA PENJUALAN</div>
  </div>
  <div class="text-xs space-y-1 mb-3">
    <div class="flex justify-between"><span class="text-slate-500">No Nota</span><span class="font-mono font-bold">{{ $nota->no_nota }}</span></div>
    <div class="flex justify-between"><span class="text-slate-500">Tanggal</span><span class="font-semibold">{{ $nota->tanggal->translatedFormat('d F Y') }}</span></div>
    @if($nota->jatuh_tempo)<div class="flex justify-between"><span class="text-slate-500">Jatuh Tempo</span><span class="font-semibold {{ $nota->is_overdue ? 'text-red-600' : '' }}">{{ $nota->jatuh_tempo->translatedFormat('d F Y') }} @if($nota->is_overdue)(Overdue)@endif</span></div>@endif
    @if($nota->metode_bayar)<div class="flex justify-between"><span class="text-slate-500">Bayar</span><span class="font-semibold capitalize">{{ $nota->metode_bayar }}</span></div>@endif
  </div>
  <div class="bg-slate-50 border rounded-xl p-3 mb-3 text-xs">
    <div class="font-bold text-sm text-[#1b2d4a]">{{ $nota->pelanggan_nama }}</div>
    @if($nota->pelanggan_hp)<div class="text-slate-600">HP: {{ $nota->pelanggan_hp }}</div>@endif
    @if($nota->pelanggan_alamat)<div class="text-slate-500">{{ $nota->pelanggan_alamat }}</div>@endif
  </div>
  <div class="border rounded-xl overflow-hidden mb-3">
    <div class="bg-slate-900 text-white px-3 py-2 text-xs font-semibold flex justify-between"><span>Rincian</span><span class="bg-white/20 px-2 py-0.5 rounded-full">{{ $nota->items->count() }} item</span></div>
    <table class="w-full text-xs leading-tight table-fixed border-collapse">
      <colgroup><col style="width:5.5%"><col style="width:49%"><col style="width:10%"><col style="width:17.5%"><col style="width:18%"></colgroup>
      <thead class="bg-slate-50 text-slate-500 text-[11px] uppercase tracking-wide"><tr><th class="px-2 py-2 text-left font-semibold">No</th><th class="px-2 py-2 text-left font-semibold">Uraian</th><th class="px-2 py-2 text-center font-semibold">Qty</th><th class="px-2 py-2 text-right font-semibold">Harga</th><th class="px-2 py-2 text-right font-semibold">Subtotal</th></tr></thead>
      <tbody class="text-sm">
        @foreach($nota->items as $i=>$it)
        <tr class="border-t">
          <td class="px-2 py-2 text-xs text-slate-500 tabular-nums">{{ $i+1 }}</td>
          <td class="px-2 py-2"><div class="font-medium text-sm break-words">{{ $it->nama }}</div><div class="text-[11px] text-slate-500">{{ $it->satuan }}@if($it->diskon_item>0) <span class="text-red-600">· Disc -{{ number_format($it->diskon_item,0,',','.') }}</span>@endif</div></td>
          <td class="px-2 py-2 text-center text-xs tabular-nums">{{ rtrim(rtrim(number_format($it->qty,2,',','.'),'0'),',') }}</td>
          <td class="px-2 py-2 text-right text-xs tabular-nums whitespace-nowrap">Rp {{ number_format($it->harga_satuan,0,',','.') }}</td>
          <td class="px-2 py-2 text-right font-semibold text-xs tabular-nums whitespace-nowrap">Rp {{ number_format($it->subtotal,0,',','.') }}</td>
        </tr>
        @endforeach
      </tbody>
      <tfoot class="text-xs">
        <tr class="border-t bg-slate-50"><td colspan="4" class="px-2 py-2 text-right text-slate-600">Subtotal</td><td class="px-2 py-2 text-right font-semibold tabular-nums">Rp {{ number_format($nota->subtotal,0,',','.') }}</td></tr>
        @if($nota->diskon_tipe && $nota->diskon_nilai>0)
        <tr class="border-t"><td colspan="4" class="px-2 py-2 text-right text-slate-600">Diskon @if($nota->diskon_tipe=='persen') {{ rtrim(rtrim(number_format($nota->diskon_nilai,2,',','.'),'0'),',') }}% @else Nominal @endif</td><td class="px-2 py-2 text-right text-red-600 tabular-nums">- Rp {{ number_format($nota->diskon_tipe=='persen' ? $nota->subtotal*$nota->diskon_nilai/100 : $nota->diskon_nilai,0,',','.') }}</td></tr>
        @endif
        @if($nota->biaya_lain>0)<tr class="border-t"><td colspan="4" class="px-2 py-2 text-right text-slate-600">{{ $nota->biaya_lain_label ?: 'Biaya Lain' }}</td><td class="px-2 py-2 text-right tabular-nums">+ Rp {{ number_format($nota->biaya_lain,0,',','.') }}</td></tr>@endif
        <tr class="border-t bg-slate-900 text-white font-bold text-sm"><td colspan="4" class="px-2 py-2 text-right">TOTAL</td><td class="px-2 py-2 text-right tabular-nums">Rp {{ number_format($nota->total,0,',','.') }}</td></tr>
      </tfoot>
    </table>
  </div>
  @if($nota->status=='lunas')
  <div class="bg-emerald-50 border-2 border-emerald-300 rounded-xl p-3 text-center mb-3">
    <div class="text-2xl">✅</div>
    <div class="text-sm font-bold text-emerald-700 tracking-widest">L U N A S</div>
    <div class="text-xs text-emerald-600 mt-1">Pembayaran telah diterima. Terima kasih.</div>
  </div>
  @elseif($nota->status=='dp')
  <div class="bg-amber-50 border-2 border-amber-300 rounded-xl p-3 text-center mb-3">
    <div class="text-xs font-bold text-amber-700 tracking-widest">D P</div>
    <div class="text-sm text-slate-700 mt-1">DP Dibayar: <b class="text-amber-700">Rp {{ number_format($nota->dp_nominal,0,',','.') }}</b></div>
    <div class="text-lg font-bold text-red-600 mt-1">Sisa: Rp {{ number_format($nota->sisa_tagihan,0,',','.') }}</div>
    @if($nota->jatuh_tempo)<div class="text-xs text-slate-600 mt-1">Jatuh tempo: {{ $nota->jatuh_tempo->translatedFormat('d F Y') }}</div>@endif
  </div>
  @else
  <div class="bg-red-50 border-2 border-red-300 rounded-xl p-3 text-center mb-3">
    <div class="text-xs font-bold text-red-600 tracking-widest">BELUM LUNAS</div>
    <div class="text-sm text-red-700 mt-1">Sisa Tagihan:</div>
    <div class="text-2xl font-bold text-red-700">Rp {{ number_format($nota->sisa_tagihan,0,',','.') }}</div>
    @if($nota->jatuh_tempo)<div class="text-xs text-red-600 mt-1">Jatuh tempo: {{ $nota->jatuh_tempo->translatedFormat('d F Y') }} @if($nota->is_overdue) — OVERDUE @endif</div>@endif
  </div>
  @endif
  @if($nota->keterangan)<div class="border rounded-xl p-3 mb-3 text-xs"><span class="text-slate-500">Ket:</span> {{ $nota->keterangan }}</div>@endif
  <div class="flex justify-between text-xs mt-4">
    <div class="text-center"><div class="mb-8 text-slate-500">Penerima</div><div class="border-t pt-1 px-6">{{ $nota->pelanggan_nama }}</div></div>
    <div class="text-center"><div class="mb-8 text-slate-500">{{ ($company->pimpinan_jabatan ?? 'Admin') }}</div><div class="border-t pt-1 px-6">{{ ($company->pimpinan_nama ?? $company->name ?? 'Datanet') }}</div></div>
  </div>
  <div class="text-center text-[10px] text-slate-400 mt-4 border-t pt-2">{{ $nota->catatan_nota ?? 'Terima kasih atas kepercayaan Anda' }}<br>Dicetak: {{ now()->translatedFormat('d/m/Y H:i') }} | No: {{ $nota->no_nota }}</div>
</div>
<script>window.onload=()=>setTimeout(()=>window.print(),400)</script>
</body>
</html>
