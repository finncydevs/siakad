<?php

namespace App\Http\Controllers\Admin\Kesiswaan\Ppdb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalonSiswa;
use App\Models\TahunPelajaran;

class DaftarCalonPesertaDidikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ambil tahun pelajaran aktif
        $tahunAktif = TahunPelajaran::where('is_active', true)->first();

        // kalau ada tahun aktif, ambil calon siswa sesuai tahun tsb
        $formulirs = [];
        if ($tahunAktif) {
            $formulirs = CalonSiswa::with(['jalurPendaftaran', 'syarat'])
                ->where('tahun_id', $tahunAktif->id)
                ->get();
        }

        return view('admin.kesiswaan.ppdb.daftar_calon_peserta_didik', compact('formulirs', 'tahunAktif'));
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
