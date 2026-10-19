<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Payroll extends Model
{
    use HasFactory;
    protected $fillable=['employee_id','periode_bulan','periode_tahun','gaji_pokok','jml_hadir','bonus_kehadiran','total_insentif','total_potongan','jam_lembur','total_lembur','catatan_lembur','total_terima','status','catatan','signature_hash','signed_at','barcode_type','barcode_data'];
    protected $casts=['gaji_pokok'=>'decimal:2','bonus_kehadiran'=>'decimal:2','total_insentif'=>'decimal:2','total_potongan'=>'decimal:2','jam_lembur'=>'decimal:2','total_lembur'=>'decimal:2','total_terima'=>'decimal:2','signed_at'=>'datetime'];
    public function employee(){ return $this->belongsTo(Employee::class); }
    public function deductions(){ return $this->hasMany(Deduction::class); }
    public function periodeLabel(): string
    {
        return str_pad((string)$this->periode_bulan,2,'0',STR_PAD_LEFT).'/'.$this->periode_tahun;
    }
    // Hitung otomatis berdasarkan data bulan berjalan + lembur manual (per periode)
    public static function hitung(int $employeeId, int $bulan, int $tahun, float $jamLembur = 0, float $totalLembur = 0, ?string $catatanLembur = null): array
    {
        $emp = Employee::findOrFail($employeeId);
        $jmlHadir = Presence::where('employee_id',$employeeId)->whereYear('tanggal',$tahun)->whereMonth('tanggal',$bulan)->where('status','hadir')->count();
        $bonus = $jmlHadir * (float)$emp->bonus_per_hadir;
        $insentif = (float) ClientAcquisition::where('employee_id',$employeeId)->whereYear('tanggal',$tahun)->whereMonth('tanggal',$bulan)->sum('nominal_insentif');
        $potongan = (float) Deduction::where('employee_id',$employeeId)->whereYear('tanggal',$tahun)->whereMonth('tanggal',$bulan)->where('status','belum_dipotong')->sum('nominal');
        $total = (float)$emp->gaji_pokok + $bonus + $insentif + $totalLembur - $potongan;
        return [
            'employee'=>$emp,
            'gaji_pokok'=>(float)$emp->gaji_pokok,
            'jml_hadir'=>$jmlHadir,
            'bonus_kehadiran'=>$bonus,
            'total_insentif'=>$insentif,
            'total_potongan'=>$potongan,
            'jam_lembur'=>$jamLembur,
            'total_lembur'=>$totalLembur,
            'catatan_lembur'=>$catatanLembur,
            'total_terima'=>$total,
        ];
    }
}
