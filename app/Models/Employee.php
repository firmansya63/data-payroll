<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = ['nama','jabatan','gaji_pokok','bonus_per_hadir','no_hp','alamat','is_active'];
    protected $casts = ['gaji_pokok'=>'decimal:2','bonus_per_hadir'=>'decimal:2','is_active'=>'boolean'];

    public function presences(){ return $this->hasMany(Presence::class); }
    public function clientAcquisitions(){ return $this->hasMany(ClientAcquisition::class); }
    public function deductions(){ return $this->hasMany(Deduction::class); }
    public function payrolls(){ return $this->hasMany(Payroll::class); }

    public function hadirCount($bulan,$tahun){
        return $this->presences()->whereYear('tanggal',$tahun)->whereMonth('tanggal',$bulan)->where('status','hadir')->count();
    }
    public function totalInsentif($bulan,$tahun){
        return $this->clientAcquisitions()->whereYear('tanggal',$tahun)->whereMonth('tanggal',$bulan)->sum('nominal_insentif');
    }
    public function totalPotongan($bulan,$tahun){
        return $this->deductions()->whereYear('tanggal',$tahun)->whereMonth('tanggal',$bulan)->where('status','belum_dipotong')->sum('nominal');
    }
}
