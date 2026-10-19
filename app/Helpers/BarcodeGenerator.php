<?php

namespace App\Helpers;

use App\Models\Payroll;
use App\Models\CompanySetting;
use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Renderer\GDLibRenderer;
use BaconQrCode\Writer;

class BarcodeGenerator
{
    /**
     * Generate signature hash untuk slip gaji
     */
    public static function generateSignatureHash(Payroll $payroll, CompanySetting $company): string
    {
        $data = [
            'payroll_id' => $payroll->id,
            'employee_id' => $payroll->employee_id,
            'periode' => $payroll->periode_bulan . '/' . $payroll->periode_tahun,
            'total' => $payroll->total_terima,
            'pimpinan' => $company->pimpinan_nama,
            // Dipakai signed_at supaya hash dapat dihitung ulang saat verifikasi
            // (kalau memakai now(), hasil verifikasi tidak akan pernah cocok).
            'timestamp' => $payroll->signed_at?->timestamp ?? now()->timestamp
        ];

        $salt = $company->signature_salt ?? config('app.key');
        $jsonData = json_encode($data);
        
        return hash_hmac('sha256', $jsonData, $salt);
    }

    /**
     * Generate data untuk barcode
     */
    public static function generateBarcodeData(Payroll $payroll, CompanySetting $company): string
    {
        // Format: PAYROLL:{ID}:{EMPLOYEE_ID}:{PERIODE}:{HASH_SHORT}
        $hash = self::generateSignatureHash($payroll, $company);
        $hashShort = substr($hash, 0, 8); // Ambil 8 karakter pertama
        
        return sprintf(
            'PAYROLL:%d:%d:%s%s:%s',
            $payroll->id,
            $payroll->employee_id,
            str_pad($payroll->periode_bulan, 2, '0', STR_PAD_LEFT),
            $payroll->periode_tahun,
            $hashShort
        );
    }

    /**
     * Generate barcode image menggunakan GD library (Code 128 sederhana yang lebih baik)
     * Implementasi yang lebih baik dengan pattern yang konsisten
     */
    public static function generateSimpleBarcode(string $data, int $width = 300, int $height = 80): string
    {
        // Create image
        $image = imagecreatetruecolor($width, $height);
        
        // Colors
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $lightGray = imagecolorallocate($image, 240, 240, 240);
        
        // Fill background
        imagefilledrectangle($image, 0, 0, $width, $height, $white);
        
        // Add light background for barcode area
        $barcodeAreaHeight = $height - 25;
        imagefilledrectangle($image, 5, 5, $width - 5, $barcodeAreaHeight, $lightGray);
        
        // Draw barcode bars dengan pattern yang lebih baik
        $dataLength = strlen($data);
        $barWidth = 2; // Lebar bar tetap
        $maxBars = floor(($width - 20) / $barWidth);
        $barsPerChar = floor($maxBars / $dataLength);
        
        $x = 10;
        
        // Generate consistent pattern based on data hash
        $hash = md5($data);
        
        for ($i = 0; $i < $dataLength && $x < $width - 10; $i++) {
            $charCode = ord($data[$i]);
            $hashChar = ord($hash[$i % 32]);
            
            // Determine bar pattern: 1 untuk bar, 0 untuk space
            $pattern = ($charCode + $hashChar) % 3;
            
            // Draw bar berdasarkan pattern
            $barHeight = 40 + (($charCode % 4) * 8); // Tinggi antara 40-64
            
            if ($pattern > 0) {
                imagefilledrectangle($image, $x, 10, $x + $barWidth - 1, 10 + $barHeight, $black);
            }
            
            $x += $barWidth;
            
            // Add small space antara bars
            if ($pattern === 0 || $pattern === 2) {
                $x += 1;
            }
        }
        
        // Add border around barcode area
        imagerectangle($image, 5, 5, $width - 5, $barcodeAreaHeight, $black);
        
        // Add text below barcode dengan font yang lebih baik
        $textY = $height - 15;
        
        // Jika tersedia GD dengan FreeType, gunakan font yang lebih baik
        if (function_exists('imagettftext')) {
            $fontSize = 8;
            $fontPath = __DIR__ . '/../../public/fonts/arial.ttf';
            
            // Cek jika font tersedia, fallback ke built-in
            if (file_exists($fontPath)) {
                $bbox = imagettfbbox($fontSize, 0, $fontPath, $data);
                $textWidth = $bbox[2] - $bbox[0];
                $textX = ($width - $textWidth) / 2;
                imagettftext($image, $fontSize, 0, $textX, $textY, $black, $fontPath, $data);
            } else {
                // Fallback ke built-in font
                $fontSize = 2;
                $textWidth = imagefontwidth($fontSize) * strlen($data);
                $textX = ($width - $textWidth) / 2;
                imagestring($image, $fontSize, $textX, $textY - 5, $data, $black);
            }
        } else {
            // Built-in font
            $fontSize = 2;
            $textWidth = imagefontwidth($fontSize) * strlen($data);
            $textX = ($width - $textWidth) / 2;
            imagestring($image, $fontSize, $textX, $textY - 5, $data, $black);
        }
        
        // Output as base64
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);
        
        return 'data:image/png;base64,' . base64_encode($imageData);
    }

    /**
     * Generate QR Code asli (ISO/IEC 18004) yang dapat discan.
     * Mengembalikan data URI PNG sehingga bisa langsung dipakai di atribut src.
     */
    public static function generateSimpleQRCode(string $data, int $size = 150): string
    {
        if (trim($data) === '') {
            $data = 'DATANET-PAYROLL';
        }

        // Ukuran minimum supaya modul QR tetap utuh (bukan pecahan pixel) saat dicetak
        $size = max(96, $size);

        // Fallback aman: slip tetap bisa dicetak walau dependency belum terpasang
        if (!class_exists(Writer::class) || !extension_loaded('gd')) {
            return self::qrFallbackImage($size);
        }

        try {
            $renderer = new GDLibRenderer($size, 4, 'png', 9);
            $png = (new Writer($renderer))->writeString($data, 'UTF-8', ErrorCorrectionLevel::M());

            return 'data:image/png;base64,' . base64_encode($png);
        } catch (\Throwable $e) {
            report($e); // tercatat di log, slip tetap tercetak

            return self::qrFallbackImage($size);
        }
    }

    /**
     * Fallback image (kotak putih ber-border) jika QR encoder tidak tersedia.
     */
    private static function qrFallbackImage(int $size): string
    {
        $image = imagecreatetruecolor($size, $size);
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);

        imagefilledrectangle($image, 0, 0, $size - 1, $size - 1, $white);
        imagerectangle($image, 0, 0, $size - 1, $size - 1, $black);
        imagestring($image, 2, 8, (int) ($size / 2) - 5, 'NO QR MODULE', $black);

        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        return 'data:image/png;base64,' . base64_encode($imageData);
    }

    /**
     * Generate signature image berdasarkan type
     * @param string $data Data untuk di-encode
     * @param string $type Type barcode (barcode atau qrcode)
     * @param string $size Size preset (small untuk A5, medium, large)
     */
    public static function generateSignatureImage(string $data, string $type = 'barcode', string $size = 'small'): string
    {
        // Size presets untuk berbagai kebutuhan
        $sizes = [
            'small' => ['width' => 180, 'height' => 40],      // A5 signature area
            'medium' => ['width' => 300, 'height' => 80],     // Standar
            'large' => ['width' => 400, 'height' => 100],     // Detail view
        ];
        
        $dimensions = $sizes[$size] ?? $sizes['medium'];
        
        // QR code butuh ukuran persegi yang cukup besar (jangan pakai dimensi barcode 1D)
        $qrSizes = [
            'small' => 160,      // slip A5
            'medium' => 220,     // preview di layar
            'large' => 320,      // halaman verifikasi / detail
        ];

        if ($type === 'qrcode') {
            return self::generateSimpleQRCode($data, $qrSizes[$size] ?? $qrSizes['medium']);
        }
        
        // Default: barcode dengan dimensi yang sesuai
        return self::generateSimpleBarcode($data, $dimensions['width'], $dimensions['height']);
    }

    /**
     * Verify signature hash
     */
    public static function verifySignatureHash(string $hash, Payroll $payroll, CompanySetting $company): bool
    {
        $expectedHash = self::generateSignatureHash($payroll, $company);
        return hash_equals($expectedHash, $hash);
    }
}
