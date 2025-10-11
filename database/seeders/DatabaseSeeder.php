<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\SemesterSeeder;
use Database\Seeders\UserSeeder; // <-- 1. Import UserSeeder
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SemesterSeeder::class,
<<<<<<< HEAD
            UserSeeder::class, // <-- 2. Panggil UserSeeder di sini
=======
            PengaturanAbsensiSeeder::class,       
>>>>>>> origin/modul/absensi
        ]);

<<<<<<< HEAD
        // User::factory()->create([ ... ]); // <-- 3. Baris ini dihapus karena sudah ditangani oleh UserSeeder
=======
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
        ]);
        
>>>>>>> origin/modul/absensi
    }
}