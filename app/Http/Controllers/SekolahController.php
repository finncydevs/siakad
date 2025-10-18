<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    /**
     * Menampilkan data detail sekolah.
     */
    public function index()
    {
        // Mengambil data sekolah pertama, atau membuat data kosong jika belum ada.
        $sekolah = Sekolah::firstOrCreate(['id' => 1]);
        return view('admin.pengaturan.sekolah.index', compact('sekolah'));
    }
}