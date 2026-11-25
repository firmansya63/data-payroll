<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualNota extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_nota','tanggal','jatuh_tempo','pelanggan_nama','pelanggan_hp','pelanggan_alamat',
        'jenis','subtotal','diskon_tipe','diskon_nilai','biaya_lain','biaya_lain_label',
        'total','dp_nominal','sisa_tagihan','status','metode_bayar','keterangan','catatan_nota','created_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jatuh_tempo' => 'date',
        'subtotal' => 'decimal:2',
        'diskon_nilai' => 'decimal:2',
        'biaya_lain' => 'decimal:2',
        'total' => 'decimal:2',
        'dp_nominal' => 'decimal:2',
        'sisa_tagihan' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(ManualNotaItem::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getIsOverdueAttribute(): bool
    {
        if (!$this->jatuh_tempo) return false;
        if ($this->status === 'lunas') return false;
        return $this->jatuh_tempo->isPast();
    }

    public function recalcTotals(): void
    {
        $subtotal = $this->items()->sum('subtotal');
        // global diskon already handled outside; this helper just sets subtotal
        $this->subtotal = $subtotal;
    }

    /**
     * Generate nomor nota otomatis berdasarkan nota yang sudah keluar,
     * dengan awalan "dt" (mis. dt-0012).
     */
    public static function generateNoNota(): string
    {
        $max = 0;
        foreach (static::pluck('no_nota') as $no) {
            if (preg_match('/^dt-?(\d+)/i', (string) $no, $m)) {
                $max = max($max, (int) $m[1]);
            }
        }
        do {
            $max++;
            $candidate = 'dt-'.str_pad((string) $max, 4, '0', STR_PAD_LEFT);
        } while (static::where('no_nota', $candidate)->exists());

        return $candidate;
    }
}
