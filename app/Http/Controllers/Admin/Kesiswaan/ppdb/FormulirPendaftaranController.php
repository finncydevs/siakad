<?php

namespace App\Http\Controllers\Admin\Kesiswaan\Ppdb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormulirPendaftaran;
use App\Models\JalurPendaftaran;
use App\Models\SyaratPendaftaran;
use App\Models\TahunPelajaran;

class FormulirPendaftaranController extends Controller
{
    public function index()
    {
        $formulirs = FormulirPendaftaran::with(['jalurPendaftaran', 'syarat'])->get();
        return view('admin.kesiswaan.ppdb.formulir_pendaftaran', compact('formulirs'));
    }

    public function create()
    {
        $tahunAktif = TahunPelajaran::where('is_active', 1)->first();
        $jalurs = JalurPendaftaran::where('is_active', true)->get();

        return view('admin.kesiswaan.ppdb.formulir_pendaftaran', [
            'formulir' => null,   // untuk tambah baru
            'jalurs' => $jalurs,
            'tahunAktif' => $tahunAktif,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_id'      => 'required|exists:tahun_pelajarans,id',
            'jalur_id'      => 'required|exists:jalur_pendaftarans,id',
            'nama_lengkap'  => 'required|string|max:255',
            'nisn'          => 'nullable|string|max:20',
            'npun'          => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tempat_lahir'  => 'nullable|string|max:100',
            'tgl_lahir'     => 'nullable|date',
            'nama_ayah'     => 'nullable|string|max:255',
            'nama_ibu'      => 'nullable|string|max:255',
            'alamat'        => 'nullable|string|max:255',
            'desa'          => 'nullable|string|max:100',
            'kecamatan'     => 'nullable|string|max:100',
            'kabupaten'     => 'nullable|string|max:100',
            'provinsi'      => 'nullable|string|max:100',
            'kode_pos'      => 'nullable|string|max:10',
            'kontak'        => 'nullable|string|max:20',
            'asal_sekolah'  => 'nullable|string|max:255',
            'kelas'         => 'nullable|string|max:20',
            'jurusan'       => 'nullable|string|max:50',
            'ukuran_pakaian'=> 'nullable|string|max:20',
            'pembayaran'    => 'nullable|numeric',
        ]);

        // Simpan formulir baru
        $formulir = FormulirPendaftaran::create($validated);

        // Simpan pivot syarat jika ada
        if ($request->has('documents')) {
            foreach ($request->documents as $syaratId => $checked) {
                $formulir->syarat()->attach($syaratId, ['is_checked' => true]);
            }
        }

        return redirect()->route('admin.kesiswaan.ppdb.formulir.index')
                         ->with('success', 'Formulir pendaftaran berhasil disimpan.');
    }

    public function edit($id)
    {
        $formulir = FormulirPendaftaran::with('syarat')->findOrFail($id);
        $jalurs = JalurPendaftaran::where('is_active', true)->get();
        $tahunAktif = TahunPelajaran::where('is_active', 1)->first();

        return view('admin.kesiswaan.ppdb.formulir_pendaftaran', [
            'formulir' => $formulir,  // untuk edit
            'jalurs' => $jalurs,
            'tahunAktif' => $tahunAktif,
        ]);
    }

    public function update(Request $request, $id)
    {
        $formulir = FormulirPendaftaran::findOrFail($id);

        $validated = $request->validate([
            'tahun_id'      => 'required|exists:tahun_pelajarans,id',
            'jalur_id'      => 'required|exists:jalur_pendaftarans,id',
            'nama_lengkap'  => 'required|string|max:255',
            'nisn'          => 'nullable|string|max:20',
            'npun'          => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tempat_lahir'  => 'nullable|string|max:100',
            'tgl_lahir'     => 'nullable|date',
            'nama_ayah'     => 'nullable|string|max:255',
            'nama_ibu'      => 'nullable|string|max:255',
            'alamat'        => 'nullable|string|max:255',
            'desa'          => 'nullable|string|max:100',
            'kecamatan'     => 'nullable|string|max:100',
            'kabupaten'     => 'nullable|string|max:100',
            'provinsi'      => 'nullable|string|max:100',
            'kode_pos'      => 'nullable|string|max:10',
            'kontak'        => 'nullable|string|max:20',
            'asal_sekolah'  => 'nullable|string|max:255',
            'kelas'         => 'nullable|string|max:20',
            'jurusan'       => 'nullable|string|max:50',
            'ukuran_pakaian'=> 'nullable|string|max:20',
            'pembayaran'    => 'nullable|numeric',
        ]);

        $formulir->update($validated);

        // Sync pivot syarat
        if ($request->has('documents')) {
            $syaratIds = array_keys($request->documents);
            $formulir->syarat()->sync(
                collect($syaratIds)->mapWithKeys(fn($id) => [$id => ['is_checked' => true]])->toArray()
            );
        } else {
            $formulir->syarat()->sync([]);
        }

        return redirect()->route('admin.kesiswaan.ppdb.formulir.index')
                         ->with('success', 'Formulir pendaftaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $formulir = FormulirPendaftaran::findOrFail($id);
        $formulir->delete();

        return redirect()->route('admin.kesiswaan.ppdb.formulir.index')
                         ->with('success', 'Formulir pendaftaran berhasil dihapus.');
    }
}
