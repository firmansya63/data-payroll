<?php

return [
    // harga jual ke reseller (modal kita) & harga ecer reseller ke pelanggan
    'types' => [
        '3k' => ['label' => '3.000',  'retail' => 3000,  'reseller' => 2500, 'margin' => 500],
        '5k' => ['label' => '5.000',  'retail' => 5000,  'reseller' => 4000, 'margin' => 1000],
        '10k' => ['label' => '10.000', 'retail' => 10000, 'reseller' => 9000, 'margin' => 1000],
    ],
    // helper fallback
    'default' => '5k',
];
