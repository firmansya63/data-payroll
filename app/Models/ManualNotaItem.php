<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualNotaItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'manual_nota_id','nama','kategori','qty','satuan','harga_satuan','diskon_item','subtotal','keterangan_item'
    ];

    protected $casts = [
        'qty' => 'decimal:2',
        'harga_satuan' => 'decimal:2',
        'diskon_item' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function nota()
    {
        return $this->belongsTo(ManualNota::class, 'manual_nota_id');
    }
}
