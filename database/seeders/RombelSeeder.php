<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RombelSeeder extends Seeder
{
    public function run(): void
    {
        // Mengosongkan tabel sebelum diisi
        DB::table('rombels')->truncate();

        DB::table('rombels')->insert([
            [
                'id' => 1,
                'nama_rombel' => 'X PPLG 1',
                'tingkat' => '10',
                'jenis_rombel' => 'Reguler',
                'kurikulum_id' => 1,
                'ruang' => 'X PPLG 1',
                'wali_id' => 35,
                'jurusan_id' => 1, // 'Pengembangan Perangkat Lunak dan Gim'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 2,
                'nama_rombel' => 'X TJKT 2',
                'tingkat' => '10',
                'jenis_rombel' => 'Reguler',
                'kurikulum_id' => 1,
                'ruang' => 'X TJKT 2',
                'wali_id' => 60,
                'jurusan_id' => 2, // 'Teknik Jaringan Komputer dan Telekomunikasi'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 3,
                'nama_rombel' => 'X TO 2',
                'tingkat' => '10',
                'jenis_rombel' => 'Reguler',
                'kurikulum_id' => 1,
                'ruang' => 'X TO 2',
                'wali_id' => 44,
                'jurusan_id' => 3, // 'Teknik Otomotif'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 4,
                'nama_rombel' => 'X TJKT 1',
                'tingkat' => '10',
                'jenis_rombel' => 'Reguler',
                'kurikulum_id' => 1,
                'ruang' => 'X TJKT 1',
                'wali_id' => 12,
                'jurusan_id' => 2, // 'Teknik Jaringan Komputer dan Telekomunikasi'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 5,
                'nama_rombel' => 'X MPLB 2',
                'tingkat' => '10',
                'jenis_rombel' => 'Reguler',
                'kurikulum_id' => 1,
                'ruang' => 'X MPLB 2',
                'wali_id' => 33,
                'jurusan_id' => 4, // 'Manajemen Perkantoran dan Layanan Bisnis'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 6,
                'nama_rombel' => 'X MPLB 1',
                'tingkat' => '10',
                'jenis_rombel' => 'Reguler',
                'kurikulum_id' => 1,
                'ruang' => 'X MPLB 1',
                'wali_id' => 55,
                'jurusan_id' => 4, // 'Manajemen Perkantoran dan Layanan Bisnis'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 7,
                'nama_rombel' => 'X DKV',
                'tingkat' => '10',
                'jenis_rombel' => 'Reguler',
                'kurikulum_id' => 1,
                'ruang' => 'X DKV',
                'wali_id' => 23,
                'jurusan_id' => 5, // 'Desain Komunikasi Visual'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 8,
                'nama_rombel' => 'X TO 1',
                'tingkat' => '10',
                'jenis_rombel' => 'Reguler',
                'kurikulum_id' => 1,
                'ruang' => 'X TO 1',
                'wali_id' => 63,
                'jurusan_id' => 3, // 'Teknik Otomotif'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 9,
                'nama_rombel' => 'X AKL 1',
                'tingkat' => '10',
                'jenis_rombel' => 'Reguler',
                'kurikulum_id' => 1,
                'ruang' => 'X AKL 1',
                'wali_id' => 53,
                'jurusan_id' => 6, // 'Akuntansi dan Keuangan Lembaga'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 10,
                'nama_rombel' => 'XI TO 2',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI TO 2',
                'wali_id' => 5,
                'jurusan_id' => 7, // 'Teknik Sepeda Motor'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 11,
                'nama_rombel' => 'XI AKL 1',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI AKL 1',
                'wali_id' => 14,
                'jurusan_id' => 8, // 'Akuntansi'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 12,
                'nama_rombel' => 'XI MPLB 2',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI MPLB 2',
                'wali_id' => 64,
                'jurusan_id' => 9, // 'Manajemen Perkantoran'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 13,
                'nama_rombel' => 'XI PPLG 1',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI PPLG 1',
                'wali_id' => 39,
                'jurusan_id' => 10, // 'Rekayasa Perangkat Lunak'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 14,
                'nama_rombel' => 'XI PPLG 2',
                'tingkat' => '11',
                'jenis_rombel' => 'Reguler',
                'kurikulum_id' => 2,
                'ruang' => 'XI PPLG 2',
                'wali_id' => null,
                'jurusan_id' => 10, // 'Rekayasa Perangkat Lunak'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 15,
                'nama_rombel' => 'XI TO 1',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI TO 1',
                'wali_id' => 47,
                'jurusan_id' => 7, // 'Teknik Sepeda Motor'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 16,
                'nama_rombel' => 'XI MPLB 1',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI MPLB 1',
                'wali_id' => 15,
                'jurusan_id' => 9, // 'Manajemen Perkantoran'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 17,
                'nama_rombel' => 'XI TJKT 2',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI TJKT 2',
                'wali_id' => 28,
                'jurusan_id' => 2, // 'Teknik Jaringan Komputer dan Telekomunikasi'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 18,
                'nama_rombel' => 'XI TJKT 1',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI TJKT 1',
                'wali_id' => 50,
                'jurusan_id' => 2, // 'Teknik Jaringan Komputer dan Telekomunikasi'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 19,
                'nama_rombel' => 'XI DKV',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI DKV',
                'wali_id' => 65,
                'jurusan_id' => 5,
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 20,
                'nama_rombel' => 'XII AKL 1',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII AKL 1',
                'wali_id' => 42,
                'jurusan_id' => 8, // 'Akuntansi'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 21,
                'nama_rombel' => 'XII MPLB 2',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII MPLB 2',
                'wali_id' => 22,
                'jurusan_id' => 9, // 'Manajemen Perkantoran'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 22,
                'nama_rombel' => 'XII MPLB 1',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII MPLB 1',
                'wali_id' => null,
                'jurusan_id' => 9, // 'Manajemen Perkantoran'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 23,
                'nama_rombel' => 'XII TJKT 1',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII TJKT 1',
                'wali_id' => 7,
                'jurusan_id' => 2, // 'Teknik Jaringan Komputer dan Telekomunikasi'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 24,
                'nama_rombel' => 'XII TJKT 2',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII TKJT 2',
                'wali_id' => 16,
                'jurusan_id' => 2, // 'Teknik Jaringan Komputer dan Telekomunikasi'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 25,
                'nama_rombel' => 'XII AKL 2',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII AKL 2',
                'wali_id' => 52,
                'jurusan_id' => 8, // 'Akuntansi'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 26,
                'nama_rombel' => 'XII PPLG 2',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII PPLG 2',
                'wali_id' => 59,
                'jurusan_id' => 10, // 'Rekayasa Perangkat Lunak'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 27,
                'nama_rombel' => 'XII TO 1',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII TO 1',
                'wali_id' => 21,
                'jurusan_id' => 7, // 'Teknik Sepeda Motor'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 28,
                'nama_rombel' => 'XII TO 2',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII TO 2',
                'wali_id' => 58,
                'jurusan_id' => 7, // 'Teknik Sepeda Motor'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 29,
                'nama_rombel' => 'XII DKV',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII DKV',
                'wali_id' => 73,
                'jurusan_id' => 5, // 'Desain Komunikasi Visual'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 30,
                'nama_rombel' => 'XII PPLG 1',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII PPLG 1',
                'wali_id' => 18,
                'jurusan_id' => 10, // 'Rekayasa Perangkat Lunak'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 31,
                'nama_rombel' => 'XII MPLB 3',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII MPLB 3',
                'wali_id' => 40,
                'jurusan_id' => 9, // 'Manajemen Perkantoran'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 32,
                'nama_rombel' => 'XI PPLG 2',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI PPLG 2',
                'wali_id' => 71,
                'jurusan_id' => 10, // 'Rekayasa Perangkat Lunak'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 33,
                'nama_rombel' => 'XI TO 2',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI TO 2',
                'wali_id' => 5,
                'jurusan_id' => 7, // 'Teknik Sepeda Motor'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 34,
                'nama_rombel' => 'XI TJKT 1',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI TJKT 1',
                'wali_id' => 50,
                'jurusan_id' => 2, // 'Teknik Jaringan Komputer dan Telekomunikasi'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 35,
                'nama_rombel' => 'XI TJKT 2',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI TJKT 2',
                'wali_id' => 28,
                'jurusan_id' => 2, // 'Teknik Jaringan Komputer dan Telekomunikasi'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 36,
                'nama_rombel' => 'XI PPLG 1',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI PPLG 1',
                'wali_id' => 39,
                'jurusan_id' => 10, // 'Rekayasa Perangkat Lunak'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 37,
                'nama_rombel' => 'XI AKL 1',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI AKL 1',
                'wali_id' => 14,
                'jurusan_id' => 8, // 'Akuntansi'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 38,
                'nama_rombel' => 'XI DKV',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI DKV',
                'wali_id' => 65,
                'jurusan_id' => 5, // 'Desain Komunikasi Visual'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 39,
                'nama_rombel' => 'XI TO 1',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI TO 1',
                'wali_id' => 47,
                'jurusan_id' => 7, // 'Teknik Sepeda Motor'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 40,
                'nama_rombel' => 'XI MPLB 1',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI MPLB 1',
                'wali_id' => 15,
                'jurusan_id' => 9, // 'Manajemen Perkantoran'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 41,
                'nama_rombel' => 'XI MPLB 2',
                'tingkat' => '11',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XI MPLB 2',
                'wali_id' => 64,
                'jurusan_id' => 9, // 'Manajemen Perkantoran'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 42,
                'nama_rombel' => 'XII PPLG 1',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII PPLG 1',
                'wali_id' => 18,
                'jurusan_id' => 10, // 'Rekayasa Perangkat Lunak'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 43,
                'nama_rombel' => 'XII DKV',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII DKV',
                'wali_id' => 73,
                'jurusan_id' => 5, // 'Desain Komunikasi Visual'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 44,
                'nama_rombel' => 'XII MPLB 1',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII MPLB 1',
                'wali_id' => null,
                'jurusan_id' => 9, // 'Manajemen Perkantoran'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 45,
                'nama_rombel' => 'XII TJKT 1',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII TJKT 1',
                'wali_id' => 7,
                'jurusan_id' => 2, // 'Teknik Jaringan Komputer dan Telekomunikasi'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 46,
                'nama_rombel' => 'XII MPLB 3',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII MPLB 3',
                'wali_id' => 40,
                'jurusan_id' => 9, // 'Manajemen Perkantoran'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 47,
                'nama_rombel' => 'XII AKL 2',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII AKL 2',
                'wali_id' => 52,
                'jurusan_id' => 8, // 'Akuntansi'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 48,
                'nama_rombel' => 'XII TO 2',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII TO 2',
                'wali_id' => 58,
                'jurusan_id' => 7, // 'Teknik Sepeda Motor'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 49,
                'nama_rombel' => 'XII AKL 1',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII AKL 1',
                'wali_id' => 42,
                'jurusan_id' => 8, // 'Akuntansi'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 50,
                'nama_rombel' => 'XII TJKT 2',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII TKJT 2',
                'wali_id' => 16,
                'jurusan_id' => 2, // 'Teknik Jaringan Komputer dan Telekomunikasi'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 51,
                'nama_rombel' => 'XII TO 1',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII TO 1',
                'wali_id' => 21,
                'jurusan_id' => 7, // 'Teknik Sepeda Motor'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 52,
                'nama_rombel' => 'XII PPLG 2',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII PPLG 2',
                'wali_id' => 59,
                'jurusan_id' => 10, // 'Rekayasa Perangkat Lunak'
                'tahun_ajaran' => 2025,
            ],
            [
                'id' => 53,
                'nama_rombel' => 'XII MPLB 2',
                'tingkat' => '12',
                'jenis_rombel' => 'Mapel Pilihan',
                'kurikulum_id' => 2,
                'ruang' => 'XII MPLB 2',
                'wali_id' => 22,
                'jurusan_id' => 9, // 'Manajemen Perkantoran'
                'tahun_ajaran' => 2025,
            ],
        ]);
    }
}