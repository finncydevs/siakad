<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Siswa;
use App\Models\AbsensiSiswa;
use Carbon\Carbon;

class TandaiSiswaAlfa extends Command
{
    protected $signature = 'absensi:tandai-alfa';
    protected $description = 'Menandai siswa tanpa catatan absensi hari ini sebagai Alfa.';

    public function handle()
    {
        $today = Carbon::now()->toDateString();

        // LANGKAH 2: Mengambil ID semua siswa yang sudah punya catatan (Hadir, Sakit, Izin).
        // Ini adalah kunci keamanannya.
        $siswaSudahAbsenIds = AbsensiSiswa::where('tanggal', $today)->pluck('siswa_id')->toArray();

        // LANGKAH 3 & 4: Mencari siswa aktif yang ID-nya TIDAK ADA di dalam daftar yang sudah absen.
        $siswaBelumAbsen = Siswa::whereNotIn('id', $siswaSudahAbsenIds)
                                 // ->where('status', 'Aktif') // Jika ada kolom status siswa
                                 ->get();

        if ($siswaBelumAbsen->isEmpty()) {
            $this->info('Tidak ada siswa yang perlu ditandai Alfa hari ini.');
            return 0;
        }

        // LANGKAH 5: Membuat record 'Alfa' hanya untuk siswa yang benar-benar "hilang".
        foreach ($siswaBelumAbsen as $siswa) {
            AbsensiSiswa::create([
                'siswa_id' => $siswa->id,
                'tanggal' => $today,
                'status' => 'Alfa',
                'keterangan' => 'Tidak ada keterangan (Otomatis oleh sistem)',
                'dicatat_oleh' => 1, // ID user 'Sistem'
            ]);
        }

        $this->info(count($siswaBelumAbsen) . ' siswa berhasil ditandai sebagai Alfa.');
        return 0;
    }
}