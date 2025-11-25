<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 10 data contoh
        for ($i = 1; $i <= 10; $i++) {
            $judul = "Kegiatan Sosial Ayobuatbaik ke-$i";

            Berita::create([
                'judul' => $judul,
                'slug' => Str::slug($judul),
                'deskripsi_singkat' => 'Kegiatan sosial ke-' . $i . ' yang dilakukan oleh komunitas Ayobuatbaik untuk membantu masyarakat sekitar.',
                'konten' => '<p>Ini adalah konten lengkap dari kegiatan sosial ke-' . $i . ' yang diadakan oleh Ayobuatbaik.</p><p>Tujuan kegiatan ini adalah untuk memberikan dampak positif bagi masyarakat.</p>',
                'gambar' => 'default/berita-sample.jpg',
                'tanggal' => now()->subDays($i)->format('Y-m-d'),
            ]);
        }
    }
}
