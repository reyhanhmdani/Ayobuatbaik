<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slider; // Pastikan Anda memiliki Model Slider
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Opsional: Hapus data lama agar seeding selalu bersih
        // DB::table('sliders')->truncate();

        $slidersData = [
            [
                'urutan' => 1,
                // Asumsi: Anda sudah menempatkan gambar ini di public/img/sliders/
                'gambar' => 'img/seeders/slider1.jpeg',
                'url' => null,
                'alt_text' => 'Slider 1',
            ],
            [
                'urutan' => 2,
                'gambar' => 'img/seeders/slider2.jpeg',
                'url' => null,
                'alt_text' => 'Banner Kegiatan Terbaru',
            ],
            [
                'urutan' => 3,
                'gambar' => 'img/seeders/slider3.jpg',
                'url' => null,
                'alt_text' => 'Dampak Kebaikan yang Telah Dilakukan',
            ],
        ];

        foreach ($slidersData as $data) {
            Slider::firstOrCreate(
                ['urutan' => $data['urutan']],
                $data
            );
        }
    }
}
