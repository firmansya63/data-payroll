<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherTransaction extends Model
{
    use HasFactory;
    protected $fillable = ['reseller_id','voucher_type','qty','harga_satuan','harga_retail','tanggal','nominal','status','keterangan','created_by'];
    protected $casts = ['tanggal'=>'date','nominal'=>'decimal:2','harga_satuan'=>'decimal:2','harga_retail'=>'decimal:2','qty'=>'integer'];
    public function reseller(){ return $this->belongsTo(Reseller::class); }
    public function creator(){ return $this->belongsTo(User::class,'created_by'); }
    public function scopeLunas($q){ return $q->where('status','lunas'); }
    public function scopeBelumLunas($q){ return $q->where('status','belum_lunas'); }

    public function getLabelAttribute(){
        $types = config('voucher.types', []);
        $t = $this->voucher_type;
        if($t && isset($types[$t])) return $types[$t]['label'];
        return $this->keterangan ? str($this->keterangan)->limit(30) : '-';
    }
    public function getRincianAttribute(){
        if($this->voucher_type && $this->qty){
            $price = config('voucher.types.'.$this->voucher_type);
            $label = $price['label'] ?? strtoupper($this->voucher_type);
            return $this->qty.' × '.$label.' @'.number_format($this->harga_satuan,0,',','.');
        }
        return $this->keterangan ? str($this->keterangan)->limit(35) : '-';
    }
}

