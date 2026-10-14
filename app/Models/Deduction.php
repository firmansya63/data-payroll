<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Deduction extends Model
{
    use HasFactory;
    protected $fillable=['employee_id','tanggal','nominal','keterangan','status','payroll_id'];
    protected $casts=['tanggal'=>'date','nominal'=>'decimal:2'];
    public function employee(){ return $this->belongsTo(Employee::class); }
    public function payroll(){ return $this->belongsTo(Payroll::class); }
}
