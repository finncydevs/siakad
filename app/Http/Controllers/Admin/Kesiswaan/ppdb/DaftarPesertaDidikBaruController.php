<?php

namespace App\Http\Controllers\Admin\Kesiswaan\Ppdb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalonSiswa;
use App\Models\TahunPelajaran;

class DaftarPesertaDidikBaruController extends Controller
{
    public function index()
    {
        // Ambil tahun aktif
        $tahunAktif = TahunPelajaran::where('is_active', true)->first();

        $pesertaDidik = collect();

        if ($tahunAktif) {
            // Ambil calon siswa tahun aktif beserta relasi
            $calonSiswas = CalonSiswa::with(['jalurPendaftaran.syaratPendaftaran', 'syarat'])
                ->where('tahun_id', $tahunAktif->id)
                ->get();

            // Filter hanya yang sudah memenuhi semua syarat
            $pesertaDidik = $calonSiswas->filter(function ($calon) {
                $totalSyarat = $calon->jalurPendaftaran
                    ? $calon->jalurPendaftaran->syaratPendaftaran()->count()
                    : 0;

                $syaratTerpenuhi = $calon->syarat->where('pivot.is_checked', true)->count();

                return $totalSyarat > 0 && $syaratTerpenuhi >= $totalSyarat;
            });
        }

        return view('admin.kesiswaan.ppdb.daftar_peserta_didik_baru', compact('pesertaDidik', 'tahunAktif'));
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
