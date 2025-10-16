<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // <-- 1. Pastikan ini di-import

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Mengosongkan tabel dengan aman
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('penggunas')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Array lengkap berisi semua data pengguna dari file SQL Anda
        $penggunas = [
            // Data disalin persis dari file SQL Anda
            ['id' => 1, 'pengguna_id' => 'ad969d86-a358-4b17-a7c1-8b23a75c7acb', 'sekolah_id' => '8f7c90fd-3517-46f7-98a7-56df1b5bf2c3', 'username' => 'hawinsmaknis@gmail.com', 'nama' => 'HAWIN MUALIF', 'peran_id_str' => 'Pelaksana PBJ', 'password' => '$2b$12$L92mhqlrIiDHZnCc5EoNley6dixj3OXEVn.S/rlWgKHEh03W0s3DC', 'alamat' => 'Kp. Sukasari', 'no_telepon' => '085722501818', 'no_hp' => '085722501818', 'ptk_id' => 'af36c40f-44dd-4beb-9b59-a63d136125ac', 'peserta_didik_id' => NULL, 'created_at' => '2022-09-08 23:37:34', 'updated_at' => '2022-09-08 23:37:34'],
            ['id' => 2, 'pengguna_id' => '30330745-fd00-44d4-b11e-222aa403b823', 'sekolah_id' => '8f7c90fd-3517-46f7-98a7-56df1b5bf2c3', 'username' => '0096149401@20203728.pd.id', 'nama' => 'Raditia Saparudin Rangkuti', 'peran_id_str' => 'Peserta Didik', 'password' => '$2y$10$PlbJr1Nt7VN2dZ3.BMw7fO6UpEEdpkSCKVDRciy8MSW/f2dNJ5N1m', 'alamat' => 'Kp. Banceuy', 'no_telepon' => NULL, 'no_hp' => NULL, 'ptk_id' => NULL, 'peserta_didik_id' => 'b940e07e-3ce7-11e5-93e0-8f94c4c9afab', 'created_at' => '2023-08-01 02:22:50', 'updated_at' => '2023-08-01 02:22:50'],
            ['id' => 3, 'pengguna_id' => 'cf0f3233-5f04-4018-a93c-7119f919c1c3', 'sekolah_id' => '8f7c90fd-3517-46f7-98a7-56df1b5bf2c3', 'username' => '0084991113@20203728.pd.id', 'nama' => 'Novita Sri Anjani', 'peran_id_str' => 'Peserta Didik', 'password' => '$2y$10$TAh7j2kHs4eEpUGkzkg45eo1PD287m8DjbvWf0rtFYTMOUAYa3.4a', 'alamat' => 'Kp. Pangarengan', 'no_telepon' => NULL, 'no_hp' => '083817909511', 'ptk_id' => NULL, 'peserta_didik_id' => 'd38cea60-27b5-11e4-be88-7f4e03a943b3', 'created_at' => '2023-08-01 02:22:50', 'updated_at' => '2023-08-01 02:22:50'],
            ['id' => 4, 'pengguna_id' => '45bc632b-56b5-4eb8-a152-5ff738069b6f', 'sekolah_id' => '8f7c90fd-3517-46f7-98a7-56df1b5bf2c3', 'username' => '0084753310@20203728.pd.id', 'nama' => 'AFNA HANIFA RAMADHANI', 'peran_id_str' => 'Peserta Didik', 'password' => '$2y$10$yN460yRBkFQhka/uEsqke.iZoJw1cooptf1A4uDlfU16OOKNYpVWi', 'alamat' => 'Kp. Pasirsereh', 'no_telepon' => NULL, 'no_hp' => '081222521793', 'ptk_id' => NULL, 'peserta_didik_id' => 'a7ab4698-4416-11e5-b56e-c3ac01928b46', 'created_at' => '2023-08-01 02:22:51', 'updated_at' => '2023-08-01 02:22:51'],
            ['id' => 5, 'pengguna_id' => 'cccbe4ae-6b9d-4836-99c9-07dd18862504', 'sekolah_id' => '8f7c90fd-3517-46f7-98a7-56df1b5bf2c3', 'username' => '3091528167@20203728.pd.id', 'nama' => 'INTAN SIFA UNNASIHAH', 'peran_id_str' => 'Peserta Didik', 'password' => '$2y$10$9z/94O5P4aN9KkNqZqVQTOqrVQPK0/QmEGvFkXaMMzQIIttTxPCAa', 'alamat' => 'KP. SIrnagalih RT.03 RW.02', 'no_telepon' => NULL, 'no_hp' => NULL, 'ptk_id' => NULL, 'peserta_didik_id' => '04d06b15-eaca-4ec0-8307-973789781249', 'created_at' => '2023-08-01 02:22:51', 'updated_at' => '2023-08-01 02:22:51'],
            ['id' => 6, 'pengguna_id' => '1d92373c-7431-432d-88b1-36e42b26b38c', 'sekolah_id' => '8f7c90fd-3517-46f7-98a7-56df1b5bf2c3', 'username' => '0095932594@20203728.pd.id', 'nama' => 'Rizki Maulana', 'peran_id_str' => 'Peserta Didik', 'password' => '$2y$10$D8b4mF4.91Gg2Q8Fh/V93..d3.Fj9B/8qD7q3U/Y/C2Tq9l9E2k/i', 'alamat' => 'Kp. Pangkalan', 'no_telepon' => NULL, 'no_hp' => NULL, 'ptk_id' => NULL, 'peserta_didik_id' => '3f37b02c-4424-11e5-b56e-c3ac01928b46', 'created_at' => '2023-08-01 02:22:51', 'updated_at' => '2023-08-01 02:22:51'],
            ['id' => 7, 'pengguna_id' => 'c0847901-57d4-46e2-9b2f-8a032c813a30', 'sekolah_id' => '8f7c90fd-3517-46f7-98a7-56df1b5bf2c3', 'username' => '0096574341@20203728.pd.id', 'nama' => 'Ripal Maulana', 'peran_id_str' => 'Peserta Didik', 'password' => '$2y$10$v7gO0Xq0y9f.N8UqW.uT3eX.w.Pj.QYg.I.X.S.Z.z.e.W.X.S.Z.z', 'alamat' => 'Kp. Cijambe', 'no_telepon' => NULL, 'no_hp' => '085794503738', 'ptk_id' => NULL, 'peserta_didik_id' => 'e7d1e8c7-4416-11e5-b56e-c3ac01928b46', 'created_at' => '2023-08-01 02:22:51', 'updated_at' => '2023-08-01 02:22:51'],
        ];
        
        // === BAGIAN YANG DIPERBAIKI ===
        // 2. Ganti password HAWIN MUALIF (data pertama, index ke-0) dengan hash yang valid.
        // Kita atur passwordnya menjadi 'password' agar mudah diingat untuk testing.
        $penggunas[0]['password'] = Hash::make('password');
        
        // Memecah data menjadi beberapa bagian (chunk) untuk efisiensi memori
        $chunks = array_chunk($penggunas, 500);

        foreach ($chunks as $chunk) {
            // Memasukkan data ke dalam tabel database
            DB::table('penggunas')->insert($chunk);
        }
    }
}