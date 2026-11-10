<?php

namespace App\Helpers;

class FormatHelper
{
    /**
     * Format angka ke format singkatan (jt, M)
     * 
     * @param int|float $number
     * @return string
     */
    public static function formatSingkat($number)
    {
        if ($number >= 1000000000) {
            return round($number / 1000000000, 1) . 'M';
        } elseif ($number >= 1000000) {
            return round($number / 1000000, 1) . 'jt';
        }
        
        return number_format($number, 0, ',', '.');
    }

    /**
     * Format rupiah dengan singkatan
     * 
     * @param int|float $number
     * @return string
     */
    public static function rupiahSingkat($number)
    {
        return 'Rp ' . self::formatSingkat($number);
    }
}
