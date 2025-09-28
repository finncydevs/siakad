<?php

namespace App\Http\Controllers\Admin\Kesiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SyaratPendaftaran;
use App\Models\TahunPelajaran;
use App\Models\JalurPendaftaran;

class SyaratController extends Controller
{
    public function index()
    {
        $tahunPpdb = TahunPelajaran::where('active', 1)->first();
        $syaratPendaftaran = SyaratPendaftaran::with('tahunPpdb')->get();
        $jalursAktif = JalurPendaftaran::where('is_active', true)->get();

        return view('admin.kesiswaan.ppdb.syarat_pendaftaran', compact('tahunPpdb', 'syaratPendaftaran', 'jalursAktif'));
    }

    public function store(Request $request)
    {
        try {
        $request->validate([
            'tahun_id' => 'required|exists:tahun_pelajarans,id',
            'jalur_id' => 'required|exists:jalur_pendaftarans,id',
            'syarat'   => 'required|string',
        ]);

        SyaratPendaftaran::create([
            'tahunPelajaran_id'     => $request->tahun_id,
            'jalurPendaftaran_id'   => $request->jalur_id,
            'syarat'                => $request->syarat,
            'is_active'         =>  0,
        ]);

        return redirect()->route('admin.ppdb.syarat-ppdb.index')->with('success', 'Syarat berhasil ditambahkan.');
        
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        $syarat = SyaratPendaftaran::findOrFail($id);
        $tahunPpdb = TahunPelajaran::where('active', 1)->first();
        $jalursAktif = JalurPendaftaran::where('is_active', true)->get();

        return view('admin.kesiswaan.ppdb.syarat_pendaftaran_edit', compact('syarat', 'tahunPpdb', 'jalursAktif'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jalur_id' => 'required|exists:jalur_pendaftarans,id',
            'syarat'   => 'required|string',
        ]);

        $syarat = SyaratPendaftaran::findOrFail($id);
        $syarat->update([
            'jalur_id' => $request->jalur_id,
            'syarat'   => $request->syarat,
        ]);

        return redirect()->route('admin.ppdb.syarat-ppdb.index')->with('success', 'Syarat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $syarat = SyaratPendaftaran::findOrFail($id);
        $syarat->delete();

        return redirect()->route('admin.ppdb.syarat-ppdb.index')->with('success', 'Syarat berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $syarat = SyaratPendaftaran::findOrFail($id);
    
        if (! $syarat->is_active) {
        
            $syarat->is_active = true;
            $syarat->save();
        
            $message = "{$syarat->syarat} berhasil dijadikan Active";
        } else {
            // kalau sudah aktif, nonaktifkan saja
            $syarat->is_active = false;
            $syarat->save();
        
            $message = "{$syarat->syarat} berhasil di-nonaktifkan";
        }
    
        return redirect()->back()->with('success', $message);
    }
}
