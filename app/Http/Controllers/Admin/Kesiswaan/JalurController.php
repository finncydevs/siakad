<?php

namespace App\Http\Controllers\Admin\Kesiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahunPelajaran;
use App\Models\JalurPendaftaran;

class JalurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahunPpdb = TahunPelajaran :: where('active', 1)->first();
        
        $jalurPendaftaran = $tahunPpdb
            ? JalurPendaftaran::where('tahunPelajaran_id', $tahunPpdb->id)->get()
            : collect(); // jika tidak ada tahun aktif, koleksi kosong
        return view('admin.kesiswaan.ppdb.jalur_pendaftaran', compact('jalurPendaftaran','tahunPpdb'));
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
        try {
            $request->validate([
                'tahun_id'      =>  'required|exists:tahun_pelajarans,id',
                'kode'          =>  'required|string',
                'jalur'         =>  'required|string',
                'keterangan'    =>  'required|string',
            ]);

            JalurPendaftaran :: create ([
                'tahunPelajaran_id' =>  $request->tahun_id,
                'kode'              =>  $request->kode,
                'jalur'             =>  $request->jalur,
                'keterangan'        =>  $request->keterangan,
                'is_active'         =>  0,
            ]);

            return redirect()->route('admin.ppdb.jalur-ppdb.index')->with('success', 'Jalur berhasil ditambahkan.');

        } catch (\Throwable $th) {
            throw $th;
        }

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
    public function edit($id)
    {
        $tahunPpdb = TahunPelajaran::where('active', 1)->first();
        $jalurPendaftaran = JalurPendaftaran::all(); // untuk table
        $editJalur = JalurPendaftaran::findOrFail($id); // untuk modal edit

        return view('admin.kesiswaan.ppdb.jalur_pendaftaran', compact(
            'tahunPpdb',
            'jalurPendaftaran',
            'editJalur'
        ));
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
        try {
            $jalur = JalurPendaftaran::findOrFail($id);
            $jalur->delete();

            return redirect()->route('admin.ppdb.jalur-ppdb.index')
                             ->with('success', "{$jalur->jalur} berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()->route('admin.ppdb.jalur-ppdb.index')
                             ->with('error', "Terjadi kesalahan: " . $e->getMessage());
        }
    }


    public function toggleActive($id)
    {
        $jalur = JalurPendaftaran::findOrFail($id);
    
        if (! $jalur->is_active) {
        
            $jalur->is_active = true;
            $jalur->save();
        
            $message = "{$jalur->jalur} berhasil dijadikan Active";
        } else {
            // kalau sudah aktif, nonaktifkan saja
            $jalur->is_active = false;
            $jalur->save();
        
            $message = "{$jalur->jalur} berhasil di-nonaktifkan";
        }
    
        return redirect()->back()->with('success', $message);
    }
}
