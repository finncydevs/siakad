<?php

namespace App\Http\Controllers\Admin\Kesiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahunPelajaran;

class TahunPpdbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        $tahunPelajaran = TahunPelajaran::orderBy('tahun_pelajaran', 'asc')->get();
    
        return view('admin.kesiswaan.ppdb.tahun_pendaftaran_ppdb', compact('tahunPelajaran'));
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
    public function show($id)
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

    public function toggleActive($id)
    {
        $tahun = TahunPelajaran::findOrFail($id);
    
        if (! $tahun->active) {
            // kalau belum aktif, set semua lain jadi nonaktif
            TahunPelajaran::query()->update(['active' => false]);
        
            $tahun->active = true;
            $tahun->save();
        
            $message = "Tahun {$tahun->tahun_pelajaran} berhasil dijadikan Active";
        } else {
            // kalau sudah aktif, nonaktifkan saja
            $tahun->active = false;
            $tahun->save();
        
            $message = "Tahun {$tahun->tahun_pelajaran} berhasil di-nonaktifkan";
        }
    
        return redirect()->back()->with('success', $message);
    }


}
