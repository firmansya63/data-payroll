# Panduan Fitur TTD Barcode Admin

## Overview
Fitur TTD (Tanda Tangan) Barcode Admin adalah sistem verifikasi digital untuk memastikan keaslian slip gaji yang diterbitkan. Setiap slip gaji memiliki signature hash unik yang dapat diverifikasi secara online.

## Fitur Utama
1. **Signature Hash Unik** - Setiap slip gaji memiliki hash SHA-256 unik
2. **Barcode/QR Code** - Dapat ditampilkan sebagai barcode atau QR code
3. **Verifikasi Online** - Dapat diverifikasi melalui website
4. **Pengaturan Fleksibel** - Dapat diatur jenis barcode dan kunci rahasia

## Cara Kerja

### 1. Generate Signature
Saat slip gaji dibuat atau dicetak pertama kali, sistem akan:
- Mengambil data slip (ID, employee, periode, total)
- Menggunakan kunci rahasia perusahaan (salt)
- Membuat hash SHA-256 unik
- Menyimpan hash dan timestamp

### 2. Format Barcode Data
```
PAYROLL:{ID}:{EMPLOYEE_ID}:{PERIODE}:{HASH_SHORT}
```
Contoh: `PAYROLL:123:456:012026:1a2b3c4d`

### 3. Display di Slip
Barcode/QR code ditampilkan di bagian bawah slip gaji bersama dengan:
- Link verifikasi online
- Informasi hash
- Waktu tanda tangan

## Cara Verifikasi

### Metode 1: Scan Barcode
1. Scan barcode/QR code di slip gaji
2. Sistem akan otomatis verifikasi jika link berisi hash lengkap

### Metode 2: Verifikasi Manual
1. Akses menu "Verifikasi TTD" di sidebar
2. Masukkan ID slip dan signature hash
3. Klik tombol verifikasi

### Metode 3: Link Langsung
Klik link "Verifikasi Online" di slip gaji untuk verifikasi otomatis

## Pengaturan

### 1. Aktifkan/Nonaktifkan
Di halaman Data Perusahaan → Pengaturan Barcode:
- ✅ Aktifkan Barcode Tanda Tangan
- Pilih jenis: Barcode (Code 128) atau QR Code

### 2. Kunci Rahasia (Salt)
- Default: menggunakan kunci aplikasi Laravel
- Dapat diubah untuk reset semua signature
- **Perhatian**: Ubah salt akan membuat semua signature sebelumnya tidak valid

### 3. Penanda Tangan
Nama dan jabatan penanda tangan dapat diatur di Data Perusahaan

## Keamanan

### 1. Hash Unik
Setiap hash dihasilkan dari:
- Data slip gaji
- Kunci rahasia perusahaan
- Timestamp

### 2. Verifikasi Aman
Sistem membandingkan hash yang ada dengan perhitungan ulang menggunakan data asli

### 3. Tidak Dapat Dipalsukan
Hash tidak dapat direkayasa tanpa kunci rahasia

## Troubleshooting

### 1. Barcode Tidak Muncul
- Pastikan fitur diaktifkan di pengaturan
- Slip harus sudah memiliki signature hash
- Coba cetak ulang slip

### 2. Verifikasi Gagal
- Periksa ID slip dan hash yang dimasukkan
- Pastikan slip belum dihapus dari sistem
- Cek pengaturan kunci rahasia

### 3. Barcode Tidak Terbaca
- Pastikan ukuran barcode cukup besar saat dicetak
- Gunakan scanner yang sesuai
- Coba gunakan QR code jika barcode bermasalah

## API Endpoints

### Verifikasi
```
GET    /signature/verify                    # Form verifikasi
GET    /signature/verify/{hash}             # Verifikasi otomatis
POST   /signature/verify/manual             # Verifikasi manual
```

### Generate Barcode
```
GET    /signature/barcode/{payroll}         # Barcode image
GET    /signature/qrcode/{payroll}          # QR code image
```

## Migration Database
Fitur ini membutuhkan kolom tambahan di tabel:
- `payrolls`: signature_hash, signed_at, barcode_type, barcode_data
- `company_settings`: signature_enabled, signature_type, signature_salt

## Developer Notes

### Class BarcodeGenerator
- Location: `app/Helpers/BarcodeGenerator.php`
- Methods: generateSignatureHash, generateBarcodeData, generateSimpleBarcode, generateSimpleQRCode

### Controller SignatureController
- Location: `app/Http/Controllers/SignatureController.php`
- Methods: verify, barcode, qrcode, verifyManual

### Views
- `resources/views/signature/verify.blade.php`    # Form verifikasi
- `resources/views/signature/result.blade.php`    # Hasil verifikasi
- `resources/views/payrolls/slip.blade.php`       # Slip dengan barcode

## Best Practices
1. **Ganti Salt Periodik** - Untuk keamanan tambahan
2. **Backup Database** - Sebelum mengubah salt
3. **Testing** - Verifikasi beberapa slip setelah konfigurasi
4. **Training** - Ajarkan cara verifikasi kepada staff

## Changelog
- **v1.0** (2026-10-15): Fitur TTD Barcode Admin pertama
- **v1.1** (2026-10-15): Perbaikan barcode generator, tambah link verifikasi online