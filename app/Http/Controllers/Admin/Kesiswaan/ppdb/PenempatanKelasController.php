<?php

namespace App\Http\Controllers\Admin\Kesiswaan\Ppdb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahunPelajaran;
use App\Models\CalonSiswa;
use App\Models\Rombel;

class PenempatanKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tahunAktif = TahunPelajaran::where('is_active', 1)->first();


        // Data untuk dropdown kelas tujuan
        $kelas = Rombel::orderBy('nama')->get();

        // ambil jurusan untuk dropdown filter
        $jurusans = Rombel::select('jurusan_id_str')
                    ->distinct()
                    ->orderBy('jurusan_id_str')
                    ->pluck('jurusan_id_str');

        // ambil data calon siswa
        $calonSiswaQuery = CalonSiswa::with(['jalurPendaftaran', 'syarat']);

        // filter: hanya yang sudah melengkapi semua syarat
        $calonSiswaQuery->whereHas('syarat', function ($q) {
            $q->where('is_checked', true);
        });

        // filter jurusan kalau ada
        if ($request->filled('jurusan')) {
            $calonSiswaQuery->where('jurusan', $request->jurusan);
        }

        $formulirs = $calonSiswaQuery->get();

        return view('admin.kesiswaan.ppdb.penempatan_kelas', compact(
            'formulirs',
            'jurusans',
            'kelas',
            'tahunAktif'
        ));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
