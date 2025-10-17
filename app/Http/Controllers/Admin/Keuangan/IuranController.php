<?php

namespace App\Http\Controllers\Admin\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\Iuran;
use App\Models\Tapel;
use Illuminate\Http\Request;

class IuranController extends Controller
{
    public function index()
    {
        $iurans = Iuran::with('tapel')->latest()->get();
        $tahunAjarans = Tapel::where('is_active', true)->get();;

        return view('admin.keuangan.iuran.index', compact('iurans', 'tahunAjarans'));
    }

    /**
     * Menyimpan iuran baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_iuran' => 'required|string|max:100',
            'tipe_iuran' => 'required|in:Bulanan,Bebas',
            'besaran_default' => 'required|numeric|min:0',
            'tahun_pelajaran_id' => 'required|exists:tapel,id',
        ]);

        Iuran::create($request->all());


        return back()->with('success', 'Data iuran berhasil ditambahkan.');
    }

    /**
     * Menyimpan perubahan data iuran.
     */
    public function update(Request $request, Iuran $iuran)
    {
        $request->validate([
            'nama_iuran' => 'required|string|max:100',
            'tipe_iuran' => 'required|in:Bulanan,Bebas',
            'besaran_default' => 'required|numeric|min:0',
            'tahun_pelajaran_id' => 'required|exists:tapel,id',
        ]);

        $iuran->update($request->all());

        return back()->with('success', 'Data iuran berhasil diperbarui.');
    }

    /**
     * Menghapus data iuran.
     */
    public function destroy(Iuran $iuran)
    {
        $iuran->delete();
        return back()->with('success', 'Data iuran berhasil dihapus.');
    }
}
