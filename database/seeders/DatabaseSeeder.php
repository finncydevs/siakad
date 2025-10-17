<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // Pastikan ini ada

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Nonaktifkan cek
        Schema::disableForeignKeyConstraints();

        // 2. KOSONGKAN TABEL (URUTAN DARI ANAK KE INDUK)
        
        DB::table('jadwal_pelajarans')->truncate();

        // ANAK TENGAH (yang bergantung ke jurusan & kurikulum)
        // DB::table('rombels')->truncate();           // <-- HARUS SEBELUM 'jurusan' DAN 'kurikulum'
        
        // INDUK
        DB::table('jurusan')->truncate();           // <-- SEKARANG AMAN
        DB::table('kurikulum')->truncate();
        DB::table('jadwal_pelajarans')->truncate(); // <-- CONTOH ANAK DARI ROMBEL
        DB::table('ekstrakurikulers')->truncate();
        // DB::table('rombels')->truncate();          // <-- INDUK (ROMBEL)
        DB::table('penggunas')->truncate();      // (Asumsi nama tabelnya 'penggunas')
        // DB::table('ptk')->truncate();              // (Asumsi nama tabelnya 'ptk')
       
        DB::table('users')->truncate(); // Jika Anda pakai 'penggunas', 'users' mungkin tidak perlu

        // 3. Aktifkan kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();

        // 4. Panggil seeder untuk MENGISI DATA (TANPA TRUNCATE LAGI)
        $this->call([
            JurusanSeeder::class,
            KurikulumSeeder::class,
            // PtkSeeder::class,
            PenggunaSeeder::class,
            // RombelSeeder::class,
            EkstrakurikulerSeeder::class,
            // Panggil seeder untuk 'jadwal_pelajarans' jika ada
        ]);
    }
}