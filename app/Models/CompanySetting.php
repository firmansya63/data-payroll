<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CompanySetting extends Model
{
    protected $fillable = ['name','tagline','address','phone','email','website','logo_path','pimpinan_nama','pimpinan_jabatan','footer_text'];

    public static function current(): self
    {
        return static::firstOrCreate(['id'=>1], [
            'name' => 'DATANET',
            'tagline' => 'Payroll & Voucher',
            'address' => 'Jl. Contoh No. 123 Kec. Contoh Kab. Contoh',
            'phone' => '08xx-xxxx-xxxx',
            'pimpinan_nama' => 'Datanet',
            'pimpinan_jabatan' => 'Admin Keuangan',
            'footer_text' => 'Slip ini sah sebagai bukti pembayaran gaji. Simpan dengan baik. Dicetak otomatis oleh sistem Datanet.',
        ]);
    }

    public function logoUrl(): string
    {
        if ($this->logo_path && Storage::disk('public')->exists($this->logo_path)) {
            return asset('storage/'.$this->logo_path);
        }
        return asset('logo.png');
    }
}
