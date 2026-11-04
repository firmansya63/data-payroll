@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 max-w-2xl mx-auto">
  <div class="mb-6">
    <h1 class="text-xl font-bold">Hasil Verifikasi Signature</h1>
    <p class="text-sm text-slate-500 mt-1">Status validasi tanda tangan admin</p>
  </div>

  <div class="bg-white border rounded-2xl p-5 md:p-6">
    <!-- Status -->
    <div class="text-center mb-6">
      @if($valid)
      <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 mb-3">
        <i class="fa-solid fa-check text-2xl"></i>
      </div>
      <h2 class="text-lg font-bold text-emerald-700">Signature Valid!</h2>
      <p class="text-sm text-emerald-600 mt-1">Tanda tangan admin terverifikasi dengan benar</p>
      @else
      <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 text-red-600 mb-3">
        <i class="fa-solid fa-xmark text-2xl"></i>
      </div>
      <h2 class="text-lg font-bold text-red-700">Signature Tidak Valid</h2>
      <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @endif
    </div>
    
    @if(isset($payroll) && $payroll)
    <!-- Informasi Slip -->
    <div class="border border-slate-200 rounded-xl p-4 mb-4">
      <h3 class="text-sm font-bold text-slate-700 mb-3">Informasi Slip Gaji</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
        <div>
          <span class="text-slate-500">ID Slip:</span>
          <span class="font-semibold ml-2">#{{ str_pad($payroll->id,6,'0',STR_PAD_LEFT) }}</span>
        </div>
        <div>
          <span class="text-slate-500">Karyawan:</span>
          <span class="font-semibold ml-2">{{ $payroll->employee->nama }}</span>
        </div>
        <div>
          <span class="text-slate-500">Periode:</span>
          <span class="font-semibold ml-2">{{ str_pad($payroll->periode_bulan,2,'0',STR_PAD_LEFT) }}/{{ $payroll->periode_tahun }}</span>
        </div>
        <div>
          <span class="text-slate-500">Total Gaji:</span>
          <span class="font-semibold ml-2">Rp {{ number_format($payroll->total_terima,0,',','.') }}</span>
        </div>
        <div>
          <span class="text-slate-500">Tanda Tangan Admin:</span>
          <span class="font-semibold ml-2">{{ $company->pimpinan_nama ?? 'Admin' }}</span>
        </div>
        <div>
          <span class="text-slate-500">Jabatan:</span>
          <span class="font-semibold ml-2">{{ $company->pimpinan_jabatan ?? 'Admin Keuangan' }}</span>
        </div>
      </div>
    </div>
    
    <!-- Detail Signature -->
    <div class="border border-slate-200 rounded-xl p-4">
      <h3 class="text-sm font-bold text-slate-700 mb-3">Detail Signature</h3>
      <div class="space-y-2 text-xs">
        <div class="flex">
          <span class="text-slate-500 w-32">Hash Signature:</span>
          <span class="font-mono break-all">{{ $hash }}</span>
        </div>
        <div class="flex">
          <span class="text-slate-500 w-32">Tanggal Tanda Tangan:</span>
          <span class="font-semibold">{{ $payroll->signed_at?->format('d/m/Y H:i') ?? 'Belum ditandatangani' }}</span>
        </div>
        <div class="flex">
          <span class="text-slate-500 w-32">Waktu Verifikasi:</span>
          <span class="font-semibold">{{ $verified_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="flex">
          <span class="text-slate-500 w-32">Status:</span>
          <span class="font-semibold {{ $valid ? 'text-emerald-600' : 'text-red-600' }}">
            {{ $valid ? 'VALID' : 'TIDAK VALID' }}
          </span>
        </div>
      </div>
      
      <!-- Barcode Preview -->
      @if($valid && $payroll->barcode_data)
      <div class="mt-4 pt-4 border-t border-slate-200">
        <h4 class="text-xs font-bold text-slate-700 mb-2">Preview Barcode</h4>
        <div class="flex justify-center">
          @php
            $isQr = (($company->signature_type ?? 'barcode') === 'qrcode');
            // QR memuat URL verifikasi supaya sekali scan langsung terbuka hasil verifikasi
            $sigPayload = ($isQr && $payroll->signature_hash)
              ? route('signature.verify.hash', $payroll->signature_hash)
              : $payroll->barcode_data;
            $imageData = \App\Helpers\BarcodeGenerator::generateSignatureImage(
              $sigPayload,
              $company->signature_type ?? 'barcode',
              'medium'
            );
          @endphp
          <img src="{{ $imageData }}" 
               alt="Preview TTD" 
               class="{{ $isQr ? 'h-40 w-40' : 'h-24' }} object-contain border p-2 bg-white"
               style="image-rendering:pixelated">
        </div>
        <div class="text-center mt-2">
          <div class="text-[9px] text-slate-400 font-mono">{{ $payroll->barcode_data }}</div>
        </div>
      </div>
      @endif
    </div>
    @else
    <!-- Hash saja -->
    <div class="border border-slate-200 rounded-xl p-4">
      <div class="text-center">
        <div class="text-xs text-slate-500 mb-2">Hash yang diverifikasi:</div>
        <div class="font-mono text-sm break-all bg-slate-50 p-3 rounded-lg">{{ $hash }}</div>
        <p class="text-[11px] text-slate-400 mt-3">
          <i class="fa-solid fa-triangle-exclamation mr-1"></i>
          Hash tidak ditemukan dalam database. Mungkin slip telah dihapus atau hash tidak valid.
        </p>
      </div>
    </div>
    @endif
    
    <!-- Actions -->
    <div class="mt-6 pt-4 border-t border-slate-200 flex flex-wrap gap-2">
      <a href="{{ route('signature.verify') }}" class="px-4 py-2 border rounded-xl text-sm">
        <i class="fa-solid fa-rotate-left mr-1"></i> Verifikasi Lainnya
      </a>
      @if(isset($payroll) && $payroll)
      <a href="{{ route('payrolls.slip', $payroll) }}" target="_blank" class="px-4 py-2 bg-slate-800 text-white rounded-xl text-sm">
        <i class="fa-solid fa-print mr-1"></i> Cetak Slip
      </a>
      <a href="{{ route('payrolls.show', $payroll) }}" class="px-4 py-2 bg-sky-600 text-white rounded-xl text-sm">
        <i class="fa-solid fa-eye mr-1"></i> Detail Slip
      </a>
      @endif
      <a href="{{ route('payrolls.index') }}" class="px-4 py-2 border rounded-xl text-sm">
        <i class="fa-solid fa-list mr-1"></i> Daftar Slip
      </a>
    </div>
  </div>
</div>
@endsection