<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- 1. Jangan lupa import DB

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 2. Nonaktifkan pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call([
            UserSeeder::class,
            PtkSeeder::class,
            JurusanSeeder::class,
            KurikulumSeeder::class,
            EkstrakurikulerSeeder::class,
        ]);

        // 3. Aktifkan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
