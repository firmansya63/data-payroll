<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Slip Gaji - {{ $payroll->employee->nama }} {{ str_pad($payroll->periode_bulan,2,'0',STR_PAD_LEFT) }}/{{ $payroll->periode_tahun }}</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
*{font-family:Inter,sans-serif; box-sizing:border-box}
@media print{
  .no-print{display:none !important}
  @page{
    size:A5 portrait;
    margin:8mm 10mm; /* Reduced top/bottom margin */
  }
  body{
    -webkit-print-color-adjust:exact;
    print-color-adjust:exact;
    font-size:10pt;
    line-height:1.2;
    margin:0;
    padding:0;
  }
  /* Compact table styling */
  table{
    border-collapse:collapse;
    font-size:9pt;
  }
  th, td{
    padding:3px 4px !important;
  }
  /* Remove unnecessary spacing */
  .mb-4, .mt-4, .mt-6, .pt-4, .pb-4{
    margin-bottom:8px !important;
    margin-top:8px !important;
    padding-top:8px !important;
    padding-bottom:8px !important;
  }
  /* Smaller barcode for A5 */
  .barcode-a5{
    height:40px !important;
    max-width:180px;
  }
  /* QR TTD admin: harus persegi & tajam saat dicetak (jangan pakai rule barcode 1D) */
  .qr-a5{
    width:80px !important;
    height:80px !important;
    max-width:none !important;
  }
  /* Compact signature area */
  .signature-compact{
    margin-top:12px !important;
    padding-top:8px !important;
  }
  /* Hide link for print */
  a[target="_blank"]{
    display:none !important;
  }
  /* Header tabel tetap terbaca walau "Background graphics" dimatikan saat cetak */
  thead{
    background:#fff !important;
    color:#1b2d4a !important;
  }
  thead th{
    border-bottom:2px solid #1b2d4a !important;
  }
}
</style>
</head>
<body class="bg-slate-100 p-3 md:p-6">
<div class="no-print max-w-[460px] mx-auto mb-3 flex gap-2">
  <button onclick="window.print()" class="flex-1 bg-[#1b2d4a] text-white py-2.5 rounded-xl font-semibold">Cetak Slip Gaji</button>
  <a href="{{ route('payrolls.index',['bulan'=>$payroll->periode_bulan,'tahun'=>$payroll->periode_tahun]) }}" class="px-4 py-2.5 border bg-white rounded-xl text-sm">Kembali</a>
</div>
<div class="max-w-[460px] mx-auto bg-white p-4 md:p-5 shadow border print:shadow-none relative">
  @php $wmLogo = isset($company) && $company ? $company->logoUrl() : asset('logo.png'); @endphp
  <!-- Watermark: banyak logo kecil (pola berulang).
       Pakai <img> (konten), bukan CSS background-image + repeat, supaya tetap
       tercetak walau opsi "Background graphics" di dialog cetak dimatikan. -->
  <div class="pointer-events-none select-none absolute inset-0 overflow-hidden z-0" aria-hidden="true">
    <div class="grid grid-cols-4 gap-x-5 gap-y-6 h-full content-between place-items-center p-2">
      @for($i = 0; $i < 24; $i++)
        <img src="{{ $wmLogo }}" alt="" class="w-14 h-14 object-contain opacity-[0.05]">
      @endfor
    </div>
  </div>
  <div class="relative z-10">
  <!-- Compact Header for A5 -->
  <div class="text-center border-b-2 border-slate-800 pb-3 mb-3">
    @php $c = $company ?? null; @endphp
    <div class="flex items-center justify-center gap-3 mb-1">
      <img src="{{ $c ? $c->logoUrl() : asset('logo.png') }}" alt="{{ $c ? $c->name : 'Datanet' }}" class="h-8 object-contain">
      <div class="text-left">
        <div class="font-bold text-base tracking-tight text-[#1b2d4a]">{{ strtoupper($c ? $c->name : 'DATANET') }}</div>
        @if($c && $c->tagline)<div class="text-[10px] text-slate-500 -mt-0.5">{{ $c->tagline }}</div>@endif
      </div>
    </div>
    <div class="text-[10px] text-slate-600 leading-tight mt-1">
      @if($c && $c->address){{ Str::limit($c->address, 60) }}@else Jl. Contoh No. 123 @endif
      @if($c && $c->phone) • {{ $c->phone }} @endif
      @if($c && $c->email) • {{ Str::limit($c->email, 35) }} @endif
    </div>
    <div class="inline-block mt-1 border border-slate-800 px-4 py-0.5 font-bold text-xs tracking-wide">SLIP GAJI</div>
    <div class="text-[11px] mt-0.5 font-semibold text-slate-700">Periode: {{ str_pad($payroll->periode_bulan,2,'0',STR_PAD_LEFT) }}/{{ $payroll->periode_tahun }}</div>
  </div>
  <!-- Compact Employee Info -->
  <div class="grid grid-cols-2 gap-3 text-xs mb-3 bg-slate-50 p-2 rounded-lg">
    <div class="space-y-1">
      <div class="flex"><span class="text-slate-500 w-16">Nama</span><span class="font-semibold pl-1">: {{ $payroll->employee->nama }}</span></div>
      <div class="flex"><span class="text-slate-500 w-16">Jabatan</span><span class="font-semibold pl-1">: {{ ucfirst($payroll->employee->jabatan) }}</span></div>
      <div class="flex"><span class="text-slate-500 w-16">No HP</span><span class="font-semibold pl-1">: {{ $payroll->employee->no_hp ?? '-' }}</span></div>
    </div>
    <div class="space-y-1">
      <div class="flex"><span class="text-slate-500 w-16">No Slip</span><span class="font-mono pl-1">: #{{ str_pad($payroll->id,6,'0',STR_PAD_LEFT) }}</span></div>
      <div class="flex"><span class="text-slate-500 w-16">Periode</span><span class="font-semibold pl-1">: {{ str_pad($payroll->periode_bulan,2,'0',STR_PAD_LEFT) }}/{{ $payroll->periode_tahun }}</span></div>
      <div class="flex"><span class="text-slate-500 w-16">Cetak</span><span class="font-semibold pl-1">: {{ now()->format('d/m/Y') }}</span></div>
    </div>
  </div>
  <!-- Compact Salary Table -->
  @php
    // Prepare table data dalam PHP untuk menghindari complex Blade syntax
    $tableRows = [];
    
    // Row 1: Gaji Pokok
    $tableRows[] = [
      'no' => '1',
      'description' => 'Gaji Pokok',
      'amount' => 'Rp ' . number_format($payroll->gaji_pokok,0,',','.'),
      'class' => 'border-b',
      'amount_class' => 'font-semibold'
    ];
    
    // Row 2: Bonus Kehadiran
    $tableRows[] = [
      'no' => '2',
      'description' => 'Bonus Kehadiran<br><span class="text-[9px] text-slate-500">' . $payroll->jml_hadir . 'x' . number_format($payroll->employee->bonus_per_hadir,0,',','.') . '</span>',
      'amount' => '+ Rp ' . number_format($payroll->bonus_kehadiran,0,',','.'),
      'class' => 'border-b',
      'amount_class' => 'font-semibold text-emerald-600'
    ];
    
    $rowNumber = 3;
    
    // Row 3+: Insentif Klien
    if($insentifList->count()) {
      $tableRows[] = [
        'no' => $rowNumber,
        'description' => 'Insentif Klien (' . $insentifList->count() . ')',
        'amount' => '+ Rp ' . number_format($payroll->total_insentif,0,',','.'),
        'class' => 'border-b',
        'amount_class' => 'font-semibold text-sky-600'
      ];
      
      // Detail insentif
      $detailHtml = '';
      if($insentifList->count() <= 3) {
        foreach($insentifList->take(3) as $it) {
          $detailHtml .= '<div class="flex justify-between"><span>' . $it->nama_klien . ' (' . $it->tanggal->format('d/m') . ')</span><span>Rp ' . number_format($it->nominal_insentif,0,',','.') . '</span></div>';
        }
      } else {
        foreach($insentifList->take(2) as $it) {
          $detailHtml .= '<div class="flex justify-between"><span>' . Str::limit($it->nama_klien,15) . ' (' . $it->tanggal->format('d/m') . ')</span><span>Rp ' . number_format($it->nominal_insentif,0,',','.') . '</span></div>';
        }
        $detailHtml .= '<div class="text-[7px] text-slate-500 text-center">+' . ($insentifList->count() - 2) . ' lainnya</div>';
      }
      
      $tableRows[] = [
        'no' => '',
        'description' => $detailHtml,
        'amount' => '',
        'class' => 'bg-sky-50/50',
        'colspan' => 2,
        'description_class' => 'text-[9px] text-sky-600 px-2 py-0.5'
      ];
      
      $rowNumber++;
    }
    
    // Row: Lembur
    if($payroll->total_lembur > 0) {
      $lemburDetail = 'Lembur';
      if($payroll->jam_lembur > 0) {
        $hours = rtrim(rtrim(number_format($payroll->jam_lembur,2,',','.'),'0'),',');
        $lemburDetail .= '<span class="text-[9px] text-slate-500">(' . $hours . ' jam)</span>';
      }
      
      $tableRows[] = [
        'no' => $rowNumber,
        'description' => $lemburDetail,
        'amount' => '+ Rp ' . number_format($payroll->total_lembur,0,',','.'),
        'class' => 'border-b bg-blue-50/30',
        'amount_class' => 'font-semibold text-blue-600'
      ];
      
      $rowNumber++;
    }
    
    // Row: Potongan
    if($payroll->total_potongan > 0) {
      $tableRows[] = [
        'no' => $rowNumber,
        'description' => 'Potongan / Kasbon<br><span class="text-[9px] text-slate-500">' . $potonganList->count() . ' potongan</span>',
        'amount' => '- Rp ' . number_format($payroll->total_potongan,0,',','.'),
        'class' => 'border-b bg-red-50/30',
        'amount_class' => 'font-bold text-red-600'
      ];
      
      // Detail potongan
      $detailHtml = '';
      if($potonganList->count() <= 3) {
        foreach($potonganList->take(3) as $p) {
          $keterangan = $p->keterangan ?? 'Potongan';
          $detailHtml .= '<div class="flex justify-between"><span>' . Str::limit($keterangan, 15) . ' (' . $p->tanggal->format('d/m') . ')</span><span>Rp ' . number_format($p->nominal,0,',','.') . '</span></div>';
        }
      } else {
        foreach($potonganList->take(2) as $p) {
          $keterangan = $p->keterangan ?? 'Potongan';
          $detailHtml .= '<div class="flex justify-between"><span>' . Str::limit($keterangan, 15) . ' (' . $p->tanggal->format('d/m') . ')</span><span>Rp ' . number_format($p->nominal,0,',','.') . '</span></div>';
        }
        $detailHtml .= '<div class="text-[7px] text-slate-500 text-center">+' . ($potonganList->count() - 2) . ' lainnya</div>';
      }
      
      $tableRows[] = [
        'no' => '',
        'description' => $detailHtml,
        'amount' => '',
        'class' => 'bg-red-50/30',
        'colspan' => 2,
        'description_class' => 'text-[9px] text-red-600 px-2 py-0.5'
      ];
      
      $rowNumber++;
    }
    
    // Row: Total
    $tableRows[] = [
      'no' => '',
      'description' => 'TOTAL DITERIMA',
      'amount' => 'Rp ' . number_format($payroll->total_terima,0,',','.'),
      'class' => 'bg-transparent text-[#1b2d4a] font-bold text-sm border-t-2 border-[#1b2d4a]',
      // tanpa colspan: supaya sel "Nominal (Rp)" ikut dirender (nominal total tidak hilang)
      'amount_class' => '!text-sm'
    ];
  @endphp
  
  <table class="w-full text-xs border">
    <thead class="bg-[#1b2d4a] text-white">
      <tr>
        <th class="px-2 py-1.5 text-left text-[10px]">No</th>
        <th class="px-2 py-1.5 text-left text-[10px]">Uraian</th>
        <th class="px-2 py-1.5 text-right text-[10px]">Nominal (Rp)</th>
      </tr>
    </thead>
    <tbody>
      @foreach($tableRows as $row)
      <tr class="{{ $row['class'] ?? '' }}">
        <td class="px-2 py-1.5 text-center text-[10px]">{{ $row['no'] }}</td>
        <td class="px-2 py-1.5 {{ $row['description_class'] ?? '' }}" @if(isset($row['colspan']))colspan="{{ $row['colspan'] }}"@endif>
          {!! $row['description'] !!}
        </td>
        @if(!isset($row['colspan']))
        <td class="px-2 py-1.5 text-right text-[10px] {{ $row['amount_class'] ?? '' }}">
          {{ $row['amount'] }}
        </td>
        @endif
      </tr>
      @endforeach
    </tbody>
  </table>
  <!-- Compact Signature Area with Integrated Barcode -->
  <div class="mt-3 pb-2 signature-compact">
    @php
      $showSignature = $company->signature_enabled ?? true;
      $signatureType = $company->signature_type ?? 'barcode';
      // Tinggi area TTD; dipakai kolom kiri & kanan supaya garis nama selalu sejajar (walau tanpa QR)
      $sigAreaH = ($signatureType === 'qrcode') ? 'h-20' : 'h-10';
    @endphp

    <div class="grid grid-cols-2 gap-3">
      <!-- Left: Employee Signature (disejajarkan dengan kolom admin) -->
      <div class="text-center pt-2">
        <div class="text-slate-500 text-[10px]">PENERIMA</div>

        <!-- Ruang tanda tangan basah; tinggi dikunci sama dengan area TTD admin
             supaya garis nama kedua kolom selalu sejajar walau tanpa QR -->
        <div class="my-1 {{ $sigAreaH }}"></div>

        <div class="border-t border-slate-300 pt-1 font-semibold text-xs">{{ $payroll->employee->nama }}</div>
        <div class="text-[9px] text-slate-400 mt-1">{{ now()->format('d/m/Y') }}</div>
      </div>

      <!-- Right: Admin Signature with Barcode -->
      <div class="text-center pt-2">
        <div class="text-slate-500 text-[10px]">{{ ($company->pimpinan_jabatan ?? 'ADMIN KEUANGAN') }}</div>

        <!-- Area TTD Digital: QR/barcode tepat di bawah jabatan, mengisi ruang tanda tangan -->
        @if($showSignature && $payroll->signature_hash && $payroll->barcode_data)
          @php
            $isQr = ($signatureType === 'qrcode');
            // QR memuat URL verifikasi (host mengikuti saat slip dicetak)
            $sigPayload = ($isQr && $payroll->signature_hash)
              ? route('signature.verify.hash', $payroll->signature_hash)
              : $payroll->barcode_data;
            $sigImage = \App\Helpers\BarcodeGenerator::generateSignatureImage($sigPayload, $signatureType, 'small');
          @endphp
          <div class="my-1">
            <img src="{{ $sigImage }}"
                 alt="TTD {{ $company->pimpinan_nama ?? 'Admin Datanet' }}"
                 class="mx-auto block {{ $isQr ? 'h-20 w-20 qr-a5 bg-white' : 'h-10 barcode-a5 object-contain bg-white' }}"
                 style="image-rendering:pixelated">
          </div>
        @else
          <!-- Ruang tanda tangan basah (tinggi dikunci, sama dengan kolom kiri) -->
          <div class="my-1 {{ $sigAreaH }}"></div>
        @endif

        <!-- Garis & nama penanda tangan (selalu di bawah area TTD) -->
        <div class="border-t border-slate-300 pt-1 text-xs">{{ ($company->pimpinan_nama ?? $company->name ?? 'DATANET') }}</div>

        <div class="text-[7px] text-slate-400 mt-0.5">
          @if($showSignature && $payroll->signature_hash && $payroll->barcode_data)
          <span class="inline-block bg-sky-100 text-sky-700 px-1 rounded">✓ TTD Digital</span>
          <a href="{{ route('signature.verify.hash', $payroll->signature_hash) }}"
             target="_blank"
             class="inline-block text-[6px] bg-slate-800 text-white px-1 py-0.5 rounded ml-1">
             Verifikasi
          </a>
          @else
          <span class="text-[9px]">{{ now()->translatedFormat('d F Y') }}</span>
          @endif
        </div>
      </div>
    </div>

    <!-- Compact Barcode Data (Hidden for Print) -->
    @if($showSignature && $payroll->signature_hash && $payroll->barcode_data)
    <div class="text-center mt-1 no-print">
      <div class="text-[7px] text-slate-500">
        Hash: {{ substr($payroll->signature_hash, 0, 16) }}...
      </div>
    </div>
    @endif
  </div>

  <!-- Compact Footer -->
  <div class="text-center text-[8px] text-slate-400 mt-2 pt-1 border-t border-slate-200">
    @php
      $footerText = $company->footer_text ?? 'Slip ini sah sebagai bukti pembayaran gaji. Simpan dengan baik.';
    @endphp
    {{ Str::limit($footerText, 80) }}
    @if(isset($showSignature) && $payroll->signature_hash)
    <span class="inline-block bg-slate-100 text-slate-600 px-1 rounded ml-1 text-[7px]">✓ TTD Digital</span>
    @endif
    <div class="text-[7px] text-slate-500 mt-0.5">
      Dicetak: {{ now()->format('d/m/Y H:i') }} • ID:#{{ str_pad($payroll->id,6,'0',STR_PAD_LEFT) }}
    </div>
  </div>
  </div><!-- /layer konten (di atas watermark) -->
</div>
<script>window.onload=()=>setTimeout(()=>window.print(),500)</script>
</body>
</html>

