<?php

namespace Database\Seeders;

use App\Models\KategoriDonasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KategoriDonasiSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            ['name' => 'Wakaf Produktif', 'deskripsi' => 'Program wakaf untuk pemberdayaan umat.'],
            ['name' => 'Pendidikan', 'deskripsi' => 'Support donasi untuk pendidikan santri dan siswa.          '],
            ['name' => 'Kemanusiaan', 'deskripsi' => 'Bantuan sosial, darurat, dan kemanusiaan.'],
            ['name' => 'Pembangunan', 'deskripsi' => 'Renovasi masjid, pesantren, dan fasilitas umum.'],
            ['name' => 'Yatim & Dhuafa', 'deskripsi' => 'Bantuan khusus untuk yatim dan dhuafa.'],
        ];

        foreach ($kategori as $kat) {
            KategoriDonasi::create([
                'name' => $kat['name'],
                'slug' => Str::slug($kat['name']),
                'deskripsi' => $kat['deskripsi'],
            ]);
        }
    }
}
