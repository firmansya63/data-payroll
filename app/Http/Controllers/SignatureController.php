<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\CompanySetting;
use App\Helpers\BarcodeGenerator;
use Illuminate\Http\Request;

class SignatureController extends Controller
{
    /**
     * Verifikasi signature dari barcode
     */
    public function verify(Request $request, $hash = null)
    {
        // Jika hash tidak diberikan, tampilkan form input
        if (!$hash) {
            return view('signature.verify');
        }

        // Cari payroll berdasarkan hash
        $payroll = Payroll::where('signature_hash', $hash)->first();
        
        if (!$payroll) {
            return view('signature.result', [
                'valid' => false,
                'message' => 'Signature tidak valid atau tidak ditemukan.',
                'hash' => $hash
            ]);
        }

        $payroll->load('employee');
        $company = \App\Models\CompanySetting::current();
        
        // Verifikasi hash
        $isValid = BarcodeGenerator::verifySignatureHash($hash, $payroll, $company);
        
        return view('signature.result', [
            'valid' => $isValid,
            'message' => $isValid ? 'Signature valid!' : 'Signature tidak valid!',
            'payroll' => $payroll,
            'company' => $company,
            'hash' => $hash,
            'verified_at' => now(),
        ]);
    }

    /**
     * Generate barcode image secara langsung
     */
    public function barcode(Request $request, Payroll $payroll)
    {
        $company = \App\Models\CompanySetting::current();
        
        if (!$payroll->barcode_data) {
            return response('Barcode data tidak tersedia', 404);
        }
        
        $type = $company->signature_type ?? 'barcode';
        $payload = ($type === 'qrcode' && $payroll->signature_hash)
            ? route('signature.verify.hash', $payroll->signature_hash)
            : $payroll->barcode_data;
        $imageData = BarcodeGenerator::generateSignatureImage($payload, $type, 'medium');
        
        // Extract base64 data
        $base64Data = substr($imageData, strpos($imageData, ',') + 1);
        $image = base64_decode($base64Data);
        
        return response($image)
            ->header('Content-Type', 'image/png')
            ->header('Content-Length', strlen($image))
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Generate QR code image secara langsung
     */
    public function qrcode(Request $request, Payroll $payroll)
    {
        $company = \App\Models\CompanySetting::current();
        
        if (!$payroll->barcode_data) {
            return response('QR Code data tidak tersedia', 404);
        }
        
        // QR memuat URL verifikasi supaya sekali scan langsung membuka hasil verifikasi
        $payload = $payroll->signature_hash
            ? route('signature.verify.hash', $payroll->signature_hash)
            : $payroll->barcode_data;
        $imageData = BarcodeGenerator::generateSimpleQRCode($payload, 320);
        
        // Extract base64 data
        $base64Data = substr($imageData, strpos($imageData, ',') + 1);
        $image = base64_decode($base64Data);
        
        return response($image)
            ->header('Content-Type', 'image/png')
            ->header('Content-Length', strlen($image))
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Verifikasi berdasarkan data input manual
     */
    public function verifyManual(Request $request)
    {
        $request->validate([
            'payroll_id' => 'required|integer',
            'signature_hash' => 'required|string|size:64', // SHA256 = 64 chars
        ]);
        
        $payroll = Payroll::find($request->payroll_id);
        
        if (!$payroll) {
            return back()->with('error', 'Slip gaji tidak ditemukan.');
        }
        
        $company = \App\Models\CompanySetting::current();
        $isValid = BarcodeGenerator::verifySignatureHash($request->signature_hash, $payroll, $company);
        
        if ($isValid) {
            return redirect()->route('signature.verify', ['hash' => $request->signature_hash])
                ->with('success', 'Signature valid!');
        } else {
            return back()->with('error', 'Signature tidak valid!');
        }
    }
}