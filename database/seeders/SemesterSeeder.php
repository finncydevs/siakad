<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('semesters')->insert([
            [
                'nama' => 'Ganjil',
                'keterangan' => 'Semester Gasal / 1',
                'is_active' => true, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Genap',
                'keterangan' => 'Semester Genap / 2',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}