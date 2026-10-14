<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ClientAcquisition extends Model
{
    use HasFactory;
    protected $fillable=['employee_id','nama_klien','alamat_klien','tanggal','nominal_insentif','keterangan'];
    protected $casts=['tanggal'=>'date','nominal_insentif'=>'decimal:2'];
    public function employee(){ return $this->belongsTo(Employee::class); }
}
