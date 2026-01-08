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
            '640x1136' => '/images/icons/splash-640x1136.png',
            '750x1334' => '/images/icons/splash-750x1334.png',
            '828x1792' => '/images/icons/splash-828x1792.png',
            '1125x2436' => '/images/icons/splash-1125x2436.png',
            '1242x2208' => '/images/icons/splash-1242x2208.png',
            '1242x2688' => '/images/icons/splash-1242x2688.png',
            '1536x2048' => '/images/icons/splash-1536x2048.png',
            '1668x2224' => '/images/icons/splash-1668x2224.png',
            '1668x2388' => '/images/icons/splash-1668x2388.png',
            '2048x2732' => '/images/icons/splash-2048x2732.png',
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