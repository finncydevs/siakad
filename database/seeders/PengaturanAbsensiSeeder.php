<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- PERBAIKAN: Tambahkan baris ini

class PengaturanAbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek jika data sudah ada, jangan buat lagi.
        if (DB::table('pengaturan_absensi')->count() == 0) {
            DB::table('pengaturan_absensi')->insert([
                'jam_masuk_sekolah' => '07:00:00',
                'jam_pulang_sekolah' => '15:00:00',
                'batas_toleransi_terlambat' => 15, // Toleransi 15 menit
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

