@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 max-w-2xl mx-auto">
  <div class="mb-6">
    <h1 class="text-xl font-bold">Verifikasi Barcode Tanda Tangan</h1>
    <p class="text-sm text-slate-500 mt-1">Verifikasi keaslian slip gaji dengan barcode tanda tangan admin</p>
  </div>

  <div class="bg-white border rounded-2xl p-5 md:p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Form Input Manual -->
      <div>
        <h2 class="text-sm font-bold text-slate-700 mb-3">Verifikasi Manual</h2>
        <form method="POST" action="{{ route('signature.verify.manual') }}">
          @csrf
          <div class="space-y-3">
            <div>
              <label class="text-xs font-semibold text-slate-600">ID Slip Gaji</label>
              <input type="number" name="payroll_id" required 
                     class="mt-1 w-full border rounded-xl px-3 py-2 text-sm" 
                     placeholder="Contoh: 123">
              <p class="text-[11px] text-slate-400 mt-1">Nomor ID slip gaji (bukan nomor karyawan)</p>
            </div>
            
            <div>
              <label class="text-xs font-semibold text-slate-600">Signature Hash</label>
              <input type="text" name="signature_hash" required 
                     class="mt-1 w-full border rounded-xl px-3 py-2 text-sm font-mono" 
                     placeholder="64 karakter hash SHA-256">
              <p class="text-[11px] text-slate-400 mt-1">Hash dari barcode (64 karakter hex)</p>
            </div>
            
            <button type="submit" class="w-full bg-[#1b2d4a] text-white py-2.5 rounded-xl text-sm font-semibold hover:brightness-110">
              <i class="fa-solid fa-magnifying-glass mr-1"></i> Verifikasi
            </button>
          </div>
        </form>
      </div>
      
      <!-- Panduan -->
      <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
        <h3 class="text-sm font-bold text-slate-700 mb-2"><i class="fa-solid fa-circle-info mr-1 text-sky-600"></i> Cara Verifikasi</h3>
        <ol class="text-xs text-slate-600 space-y-2">
          <li class="flex items-start">
            <span class="bg-slate-200 rounded-full w-5 h-5 flex items-center justify-center text-[10px] font-bold mr-2 flex-shrink-0">1</span>
            <span>Scan barcode/QR code di slip gaji menggunakan scanner atau aplikasi barcode reader</span>
          </li>
          <li class="flex items-start">
            <span class="bg-slate-200 rounded-full w-5 h-5 flex items-center justify-center text-[10px] font-bold mr-2 flex-shrink-0">2</span>
            <span>Format barcode: <code class="font-mono text-[10px]">PAYROLL:{ID}:{EMPLOYEE_ID}:{PERIODE}:{HASH_SHORT}</code></span>
          </li>
          <li class="flex items-start">
            <span class="bg-slate-200 rounded-full w-5 h-5 flex items-center justify-center text-[10px] font-bold mr-2 flex-shrink-0">3</span>
            <span>Klik link "Verifikasi Online" di slip atau masukkan ID slip dan hash ke form untuk verifikasi manual</span>
          </li>
          <li class="flex items-start">
            <span class="bg-slate-200 rounded-full w-5 h-5 flex items-center justify-center text-[10px] font-bold mr-2 flex-shrink-0">4</span>
            <span>Sistem akan memverifikasi keaslian tanda tangan admin dengan data perusahaan</span>
          </li>
        </ol>
        
        <div class="mt-4 pt-3 border-t border-slate-200 space-y-2">
          <p class="text-[11px] text-slate-500">
            <i class="fa-solid fa-shield-check mr-1 text-emerald-600"></i>
            Setiap slip gaji memiliki signature hash unik yang dihasilkan dari data slip dan kunci rahasia perusahaan.
          </p>
          <p class="text-[11px] text-slate-500">
            <i class="fa-solid fa-gear mr-1 text-sky-600"></i>
            Pengaturan barcode dapat diubah di <a href="{{ route('settings.company.index') }}" class="text-sky-600 hover:underline">Data Perusahaan → Pengaturan Barcode</a>
          </p>
          <p class="text-[11px] text-slate-500">
            <i class="fa-solid fa-print mr-1 text-amber-600"></i>
            Barcode akan otomatis dibuat saat slip gaji dicetak pertama kali.
          </p>
        </div>
      </div>
    </div>
    
    <!-- Link ke daftar slip -->
    <div class="mt-6 pt-4 border-t border-slate-200">
      <p class="text-xs text-slate-500">
        Ingin melihat daftar slip gaji? 
        <a href="{{ route('payrolls.index') }}" class="text-sky-600 font-semibold hover:underline">Buka Daftar Slip Gaji →</a>
      </p>
    </div>
  </div>
</div>
@endsection