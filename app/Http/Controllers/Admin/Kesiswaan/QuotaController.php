<?php

namespace App\Http\Controllers\Admin\Kesiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuotaPendaftaran;
use App\Models\TahunPelajaran;

class QuotaController extends Controller
{
    public function index()
    {
        $tahunPpdb = TahunPelajaran::where('active', 1)->first();
        $quotas = $tahunPpdb
            ? QuotaPendaftaran::where('tahunPelajaran_id', $tahunPpdb->id)->get()
            : collect(); // jika tidak ada tahun aktif, koleksi kosong;

        return view('admin.kesiswaan.ppdb.quota_pendaftaran', compact('quotas', 'tahunPpdb'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_id' => 'required|exists:tahun_pelajarans,id',
            'keahlian' => 'required|string',
            'jumlah_kelas' => 'required|integer',
            'quota' => 'required|integer',
        ]);

        QuotaPendaftaran::create([
            'tahunPelajaran_id' => $request->tahun_id,
            'keahlian' => $request->keahlian,
            'jumlah_kelas' => $request->jumlah_kelas,
            'quota' => $request->quota,
        ]);

        return redirect()->back()->with('success', 'Quota berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'keahlian' => 'required|string',
            'jumlah_kelas' => 'required|integer',
            'quota' => 'required|integer',
        ]);

        $quota = QuotaPendaftaran::findOrFail($id);
        $quota->update([
            'keahlian' => $request->keahlian,
            'jumlah_kelas' => $request->jumlah_kelas,
            'quota' => $request->quota,
        ]);

        return redirect()->back()->with('success', 'Quota berhasil diupdate.');
    }

    public function destroy($id)
    {
        $quota = QuotaPendaftaran::findOrFail($id);
        $quota->delete();

        return redirect()->back()->with('success', 'Quota berhasil dihapus.');
    }
}
