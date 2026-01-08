<?php

return [
    'name' => 'Ayobuatbaik',
    'manifest' => [
        'name' => 'Ayobuatbaik',
        'short_name' => 'Ayobuatbaik',
        'start_url' => '/',
        'background_color' => '#111827',
        'theme_color' => '#D4AF37',
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => 'black',
        'icons' => [
            '72x72' => [
                'path' => '/icon ABBI.png',
                'purpose' => 'any',
            ],
            '192x192' => [
                'path' => '/icon ABBI.png',
                'purpose' => 'any',
            ],
            '512x512' => [
                'path' => '/icon ABBI.png',
                'purpose' => 'any',
            ],
        ],
        'splash' => [
            // Dikosongkan agar lebih ringan, sudah menggunakan icon utama
        ],
        'shortcuts' => [
            [
                'name' => 'Kitab Hikmah',
                'description' => 'Baca kitab Nashaihul Ibad',
                'url' => '/kitab',
                'icons' => [
                    'src' => '/icon ABBI.png',
                    'purpose' => 'any',
                ],
            ],
            [
                'name' => 'Program Donasi',
                'description' => 'Lihat daftar program donasi aktif',
                'url' => '/programs',
                'icons' => [
                    'src' => '/icon ABBI.png',
                    'purpose' => 'any',
                ],
            ],
        ],
        'custom' => []
    ]
];