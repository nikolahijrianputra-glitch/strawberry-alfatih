<?php

return [
    'name' => 'Strawberry Alfatih',

    // Nomor WhatsApp toko, format internasional tanpa "+" (0853-7474-8715 => 6285374748715).
    'whatsapp' => env('STORE_WHATSAPP', '6285374748715'),

    // Isi lewat .env setelah data asli tersedia; kosong = tidak ditampilkan di footer.
    'address'  => env('STORE_ADDRESS'),
    'maps_url' => env('STORE_MAPS_URL'),

    'categories' => ['Cake', 'Cheesecake', 'Brownies', 'Shortcake', 'Lainnya'],

    'force_https' => (bool) env('FORCE_HTTPS', false),
];
