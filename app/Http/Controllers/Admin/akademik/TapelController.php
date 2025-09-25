<?php

namespace App\Http\Controllers\Admin\Akademik;

use App\Http\Controllers\Controller;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;

class TapelController extends Controller
{
    public function index()
    {
        // PERBAIKAN DI SINI:
        // Urutkan berdasarkan 'is_active' secara DESC (TRUE/1 akan di atas)
        // Kemudian urutkan berdasarkan 'tahun_pelajaran' secara DESC (untuk sisanya)
        $tahun_pelajarans = TahunPelajaran::orderBy('is_active', 'desc')
                                          ->orderBy('tahun_pelajaran', 'desc')
                                          ->get();

        // Menggunakan view path sesuai struktur folder yang baru: admin.akademik.tapel.index
        return view('admin.akademik.tapel.index', compact('tahun_pelajarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_pelajaran' => 'required|string|unique:tahun_pelajarans,tahun_pelajaran',
            'keterangan' => 'nullable|string',
        ]);

        TahunPelajaran::create($request->all());

        return redirect()->route('admin.akademik.tapel.index')->with('success', 'Tahun Pelajaran berhasil ditambahkan.');
    }

    public function destroy(TahunPelajaran $tapel)
    {
        if ($tapel->is_active) {
            return back()->with('error', 'Tidak dapat menghapus Tahun Pelajaran yang aktif.');
        }

        $tapel->delete();

        return redirect()->route('admin.akademik.tapel.index')->with('success', 'Tahun Pelajaran berhasil dihapus.');
    }

    public function toggleStatus(TahunPelajaran $tapel)
    {
        if ($tapel->is_active) {
            return back()->with('error', 'Tahun Pelajaran sudah aktif.');
        }

        // Panggil static method di Model untuk mengaktifkan hanya satu
        TahunPelajaran::setActive($tapel->id);

        return back()->with('success', 'Tahun Pelajaran berhasil diaktifkan.');
    }
}