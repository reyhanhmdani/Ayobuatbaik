<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@gmail.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('12345'),
            ]
        );
        $this->call([
            KategoriDonasiSeeder::class,
            PenggalangDanaSeeder::class,
            ProgramDonasiSeeder::class,
            BeritaSeeder::class,
            SliderSeeder::class,
        ]);
    }
}
