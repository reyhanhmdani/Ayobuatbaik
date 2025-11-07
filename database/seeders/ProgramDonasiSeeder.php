<?php

namespace Database\Seeders;

use App\Models\KategoriDonasi;
use App\Models\PenggalangDana;
use App\Models\ProgramDonasi;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProgramDonasiSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = KategoriDonasi::all();
        $penggalang = PenggalangDana::all();

        $programs = [
            [
                'title' => 'Wakaf Sumur Pesantren',
                'short_description' => 'Pembangunan sumur pesantren untuk kebutuhan santri.',
                'target_amount' => 50000000,
                'verified' => true,
                'status' => 'active',
                'featured' => true,
            ],
            [
                'title' => 'Bantuan Pendidikan Santri',
                'short_description' => 'Bantuan kitab, alat tulis, dan kebutuhan pendidikan.',
                'target_amount' => 30000000,
                'verified' => true,
                'status' => 'active',
            ],
            [
                'title' => 'Renovasi Masjid Al-Ikhlas',
                'short_description' => 'Renovasi fasilitas masjid dan perbaikan atap.',
                'target_amount' => 100000000,
                'verified' => false,
                'status' => 'draft',
            ],
            [
                'title' => 'Bantuan Kemanusiaan Palestina',
                'short_description' => 'Bantuan darurat untuk saudara-saudara di Palestina.',
                'target_amount' => 200000000,
                'verified' => true,
                'status' => 'active',
                'featured' => true,
            ],
            [
                'title' => 'Santunan Anak Yatim',
                'short_description' => 'Santunan bulanan dan kebutuhan pangan.',
                'target_amount' => 25000000,
                'verified' => false,
                'status' => 'active',
            ],
        ];

        foreach ($programs as $p) {
            $selectedKategori = $kategori->random();
            $selectedPenggalang = $penggalang->random();

            ProgramDonasi::create([
                'title' => $p['title'],
                'slug' => Str::slug($p['title']).'-'.Str::random(4),
                'kategori_id' => $selectedKategori->id,
                'penggalang_id' => $selectedPenggalang->id,
                'target_amount' => $p['target_amount'],
                'collected_amount' => rand(0, $p['target_amount']),
                'start_date' => Carbon::now()->subDays(rand(1, 30)),
                'end_date' => Carbon::now()->addDays(rand(10, 40)),
                'short_description' => $p['short_description'],
                'deskripsi' => $p['short_description'],
                'verified' => $p['verified'],
                'status' => $p['status'],
                'featured' => $p['featured'] ?? false,
                'gambar' => null, // nanti bisa kamu isi
            ]);
        }
    }
}
