@extends('layouts.app')
@section('title','Data Perusahaan')
@section('content')
<div class="flex items-center justify-between mb-4">
  <div>
    <h1 class="text-xl font-bold">Data Perusahaan</h1>
    <p class="text-xs text-slate-500 mt-1">Informasi ini akan tampil di kop Slip Gaji & Nota</p>
  </div>
  <a href="{{ route('dashboard') }}" class="text-xs border bg-white px-3 py-1.5 rounded-xl">Kembali</a>
</div>

<form method="POST" action="{{ route('settings.company.update') }}" enctype="multipart/form-data" class="bg-white p-4 md:p-6 rounded-2xl shadow-sm border space-y-5">
  @csrf @method('PUT')

  <div class="grid md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
      <label class="text-xs font-semibold text-slate-600">Nama Perusahaan *</label>
      <input type="text" name="name" value="{{ old('name',$company->name) }}" required class="mt-1 w-full border rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="DATANET">
    </div>
    <div>
      <label class="text-xs font-semibold text-slate-600">Tagline / Sub Judul</label>
      <input type="text" name="tagline" value="{{ old('tagline',$company->tagline) }}" class="mt-1 w-full border rounded-xl px-3 py-2 text-sm" placeholder="Payroll & Voucher">
      <p class="text-[11px] text-slate-400 mt-1">Tampil kecil di bawah nama (opsional)</p>
    </div>
    <div>
      <label class="text-xs font-semibold text-slate-600">Telepon</label>
      <input type="text" name="phone" value="{{ old('phone',$company->phone) }}" class="mt-1 w-full border rounded-xl px-3 py-2 text-sm" placeholder="08xx-xxxx-xxxx">
    </div>
    <div class="md:col-span-2">
      <label class="text-xs font-semibold text-slate-600">Alamat Lengkap</label>
      <textarea name="address" rows="2" class="mt-1 w-full border rounded-xl px-3 py-2 text-sm" placeholder="Jl. Contoh No.123 Kec. Contoh Kab. Contoh">{{ old('address',$company->address) }}</textarea>
    </div>
    <div>
      <label class="text-xs font-semibold text-slate-600">Email</label>
      <input type="email" name="email" value="{{ old('email',$company->email) }}" class="mt-1 w-full border rounded-xl px-3 py-2 text-sm" placeholder="admin@datanet.net">
    </div>
    <div>
      <label class="text-xs font-semibold text-slate-600">Website</label>
      <input type="text" name="website" value="{{ old('website',$company->website) }}" class="mt-1 w-full border rounded-xl px-3 py-2 text-sm" placeholder="www.datanet.net">
    </div>
  </div>

  <div class="border-t pt-5">
    <p class="text-xs font-bold tracking-[0.12em] text-slate-400 mb-3">LOGO</p>
    <div class="flex gap-4 items-start">
      <div class="shrink-0 w-20 h-20 bg-slate-50 border rounded-xl grid place-items-center overflow-hidden">
        <img src="{{ $company->logoUrl() }}" alt="Logo" class="w-full h-full object-contain p-1.5">
      </div>
      <div class="flex-1">
        <label class="text-xs font-semibold text-slate-600">Ganti Logo</label>
        <input type="file" name="logo" accept="image/png,image/jpeg,image/webp" class="mt-1 w-full text-sm border rounded-xl px-3 py-2 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-slate-900 file:text-white file:text-xs">
        <p class="text-[11px] text-slate-400 mt-1">PNG/JPG/WEBP, max 2MB. Disarankan kotak 512x512</p>
        @if($company->logo_path)
        <label class="flex items-center gap-2 mt-2 text-xs text-red-600"><input type="checkbox" name="remove_logo" value="1"> Hapus logo (kembali ke default)</label>
        @endif
      </div>
    </div>
  </div>

  <div class="border-t pt-5 grid md:grid-cols-2 gap-4">
    <div>
      <label class="text-xs font-semibold text-slate-600">Nama Pimpinan / Penanda Tangan</label>
      <input type="text" name="pimpinan_nama" value="{{ old('pimpinan_nama',$company->pimpinan_nama) }}" class="mt-1 w-full border rounded-xl px-3 py-2 text-sm" placeholder="Datanet">
    </div>
    <div>
      <label class="text-xs font-semibold text-slate-600">Jabatan Penanda Tangan</label>
      <input type="text" name="pimpinan_jabatan" value="{{ old('pimpinan_jabatan',$company->pimpinan_jabatan) }}" class="mt-1 w-full border rounded-xl px-3 py-2 text-sm" placeholder="Admin Keuangan">
    </div>
    <div class="md:col-span-2">
      <label class="text-xs font-semibold text-slate-600">Teks Footer Slip</label>
      <input type="text" name="footer_text" value="{{ old('footer_text',$company->footer_text) }}" class="mt-1 w-full border rounded-xl px-3 py-2 text-sm" placeholder="Slip ini sah sebagai bukti pembayaran gaji...">
      <p class="text-[11px] text-slate-400 mt-1">Tampil kecil di paling bawah slip</p>
    </div>
  </div>

  <div class="border-t pt-4 mt-4">
    <h2 class="text-sm font-bold text-slate-700 mb-3">Pengaturan Barcode Tanda Tangan</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="flex items-center">
        <input type="checkbox" name="signature_enabled" value="1" id="signature_enabled" 
               {{ old('signature_enabled',$company->signature_enabled ?? true) ? 'checked' : '' }}
               class="mr-2 h-4 w-4 rounded border-slate-300">
        <label for="signature_enabled" class="text-xs font-semibold text-slate-600">
          Aktifkan Barcode Tanda Tangan
        </label>
      </div>
      
      <div>
        <label class="text-xs font-semibold text-slate-600 block mb-1">Jenis Barcode</label>
        <div class="flex gap-3">
          <label class="text-xs flex items-center">
            <input type="radio" name="signature_type" value="barcode" 
                   {{ old('signature_type',$company->signature_type ?? 'barcode') == 'barcode' ? 'checked' : '' }}
                   class="mr-1">
            Barcode (Code 128)
          </label>
          <label class="text-xs flex items-center">
            <input type="radio" name="signature_type" value="qrcode"
                   {{ old('signature_type',$company->signature_type ?? 'barcode') == 'qrcode' ? 'checked' : '' }}
                   class="mr-1">
            QR Code
          </label>
        </div>
        <p class="text-[11px] text-slate-400 mt-1">Muncul di bawah tanda tangan admin di slip gaji</p>
      </div>
      
      <div class="md:col-span-2">
        <label class="text-xs font-semibold text-slate-600">Kunci Rahasia (Salt) <span class="text-slate-400">- opsional</span></label>
        <input type="text" name="signature_salt" value="{{ old('signature_salt',$company->signature_salt) }}" 
               class="mt-1 w-full border rounded-xl px-3 py-2 text-sm" 
               placeholder="Biarkan kosong untuk menggunakan kunci default aplikasi">
        <p class="text-[11px] text-slate-400 mt-1">Digunakan untuk generate hash tanda tangan. Ubah jika perlu reset semua tanda tangan.</p>
      </div>
    </div>
  </div>

  <div class="flex gap-2 pt-6">
    <button type="submit" class="bg-[#1b2d4a] text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:brightness-110"><i class="fa-solid fa-floppy-disk mr-1"></i> Simpan</button>
    <a href="{{ route('dashboard') }}" class="px-6 py-2.5 rounded-xl text-sm border bg-white">Batal</a>
  </div>
</form>

<div class="mt-4 bg-sky-50 border border-sky-200 p-3 rounded-2xl text-xs text-sky-800">
  <i class="fa-solid fa-circle-info mr-1"></i> Setelah disimpan, buka salah satu <a href="{{ route('payrolls.index') }}" class="underline font-semibold">Slip Gaji → Cetak</a> untuk melihat hasilnya. Logo juga tampil di sidebar dan login.
</div>
@endsection
