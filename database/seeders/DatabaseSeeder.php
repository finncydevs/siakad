<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Pastikan ini di-import

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // 1. Nonaktifkan pengecekan foreign key untuk kelancaran proses seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. Panggil semua class seeder yang Anda miliki.
        // Urutan di sini penting jika ada ketergantungan data.
        // Pastikan seeder untuk tabel master (seperti jurusan) dijalankan sebelum
        // seeder untuk tabel transaksi (seperti rombel).
        $this->call([
            // UserSeeder::class, // Sebaiknya dinonaktifkan jika Anda sudah menggunakan PenggunaSeeder untuk otentikasi
            JurusanSeeder::class,
            KurikulumSeeder::class,
            PtkSeeder::class,
            PenggunaSeeder::class, // Seeder ini mengisi data login
            RombelSeeder::class,
            EkstrakurikulerSeeder::class,
        ]);

        // 3. Aktifkan kembali pengecekan foreign key setelah proses selesai
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}