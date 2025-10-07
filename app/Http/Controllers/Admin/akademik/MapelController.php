<?php

namespace App\Http\Controllers\Admin\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Menggunakan DB Facade untuk Query Builder

/**
 * Controller untuk mengelola data Mata Pelajaran (Mapel).
 * Lokasi: app/Http/Controllers/Admin/Akademik/MapelController.php
 */
class MapelController extends Controller
{
    /**
     * Mengambil dan menampilkan daftar unik Mata Pelajaran
     * dari kolom JSON 'pembelajaran' di tabel 'rombels'.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. Ambil kolom 'pembelajaran' dari semua rombel
        $rombels = DB::table('rombels')
            ->select('pembelajaran')
            ->get();
            
        $uniqueMapels = [];
            
        // 2. Iterasi dan ekstrak Mata Pelajaran (Mapel) yang unik
        foreach ($rombels as $rombel) {
            // Decode string JSON/TEXT di kolom 'pembelajaran'
            $pembelajaran_data = json_decode($rombel->pembelajaran, true);
            
            if (is_array($pembelajaran_data)) {
                foreach ($pembelajaran_data as $pembelajaran) {
                    $mapel_id = $pembelajaran['mata_pelajaran_id'] ?? null;
                    $mapel_nama = $pembelajaran['mata_pelajaran_id_str'] ?? 'N/A';

                    // Hanya proses jika memiliki ID dan Nama
                    if ($mapel_id && $mapel_nama !== 'N/A') {
                        // Gunakan ID sebagai key untuk memastikan Mata Pelajaran unik
                        if (!isset($uniqueMapels[$mapel_id])) {
                            $uniqueMapels[$mapel_id] = [
                                'kode' => $mapel_id,
                                'nama_mapel' => $mapel_nama,
                            ];
                        }
                    }
                }
            }
        }

        // 3. Konversi array asosiatif (dengan key ID) menjadi array biasa untuk di-view
        $daftarMapel = array_values($uniqueMapels);

        // 4. Kirim data ke view
        return view('admin.akademik.mapels.index', [
            'mapels' => $daftarMapel
        ]);
    }
}