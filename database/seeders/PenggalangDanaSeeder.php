<?php

namespace Database\Seeders;

use App\Models\PenggalangDana;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenggalangDanaSeeder extends Seeder
{
    public function run(): void
    {
        $penggalang = [
            ['nama' => 'Yayasan Nurul Falah', 'tipe' => 'yayasan', 'kontak' => '081234567890'],
            ['nama' => 'Komunitas Pemuda Hijrah', 'tipe' => 'komunitas', 'kontak' => '081298765432'],
            ['nama' => 'Abdullah Faiz', 'tipe' => 'individu', 'kontak' => '081377889900'],
            ['nama' => 'Yayasan Berbagi Rezeki', 'tipe' => 'yayasan'],
            ['nama' => 'Siti Rahmawati', 'tipe' => 'individu'],
        ];

        foreach ($penggalang as $p) {
            PenggalangDana::create($p);
        }
    }
}
