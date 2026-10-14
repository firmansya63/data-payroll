<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reseller extends Model
{
    use HasFactory;
    protected $fillable = ['nama','no_hp','alamat','catatan'];
    public function transactions()
    {
        return $this->hasMany(VoucherTransaction::class);
    }
    public function getTotalPiutangAttribute()
    {
        return $this->transactions()->where('status','belum_lunas')->sum('nominal');
    }
}
