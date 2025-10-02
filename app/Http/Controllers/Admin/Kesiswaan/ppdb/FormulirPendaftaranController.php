<?php

namespace App\Http\Controllers\Admin\Kesiswaan\Ppdb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalonSiswa;
use App\Models\JalurPendaftaran;
use App\Models\SyaratPendaftaran;
use App\Models\TahunPelajaran;

class FormulirPendaftaranController extends Controller
{
    public function index()
    {
        $tahunAktif = TahunPelajaran::where('is_active', 1)->first();

        $formulirs = CalonSiswa::with(['jalurPendaftaran', 'syarat'])->get();

        $jalurs = $tahunAktif
            ? JalurPendaftaran::where('tahunPelajaran_id', $tahunAktif->id)
                ->where('is_active', true)
                ->get()
            : collect();

        $syarats = $tahunAktif
            ? SyaratPendaftaran::where('tahunPelajaran_id', $tahunAktif->id)
                ->where('is_active', true)
                ->get()
            : collect();

        return view('admin.kesiswaan.ppdb.formulir_pendaftaran', compact(
            'formulirs',
            'jalurs',
            'tahunAktif',
            'syarats'
        ));
    }

    public function create()
    {
        $tahunAktif = TahunPelajaran::where('is_active', 1)->first();

        $jalurs = $tahunAktif
            ? JalurPendaftaran::where('tahunPelajaran_id', $tahunAktif->id)
                ->where('is_active', true)
                ->get()
            : collect();

        $syarats = $tahunAktif
            ? SyaratPendaftaran::where('tahunPelajaran_id', $tahunAktif->id)
                ->where('is_active', true)
                ->get()
            : collect();

        return view('admin.kesiswaan.ppdb.formulir_pendaftaran_form', [
            'formulir'   => null,
            'jalurs'     => $jalurs,
            'tahunAktif' => $tahunAktif,
            'syarats'    => $syarats,
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
        // ====== Generate Nomor Seri ======
        $prefix = "137"; // bisa diset sesuai kode unit
        $tanggal = now()->format('ymd'); // contoh: 250930 (30 Sept 2025)
        
        // hitung urutan hari ini
        $last = CalonSiswa::whereDate('created_at', now()->toDateString())
                    ->orderByDesc('id')
                    ->first();

        if ($last) {
            // ambil angka setelah titik
            $lastNumber = (int) substr($last->nomer_seri, -3);
            $urutan = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $urutan = "001";
        }

        $nomerSeri = "{$prefix}-{$tanggal}.{$urutan}";

        // masukkan ke validated
        $validated['nomor_resi'] = $nomerSeri;

         if ($request->action === 'create') {
            // tombol Baru → selalu buat entri baru
            $calon = CalonSiswa::create($validated);
        } else {
            // tombol Simpan → kalau ada id, update data
            if ($request->id) {
                $calon = CalonSiswa::findOrFail($request->id);
                $calon->update($validated);
            } else {
                $calon = CalonSiswa::create($validated);
            }
        }
    
        // Simpan syarat
        $syaratIds = $request->syarat_id ?? [];
        $syncData = [];
        foreach ($syaratIds as $id) {
            $syncData[$id] = ['is_checked' => true];
        }
        $calon->syarat()->sync($syncData);

        
        return redirect()->back()->with('success', 'Formulir calon peserta didik berhasil disimpan.');
    }

    public function edit($id)
    {
        $formulir = CalonSiswa::with('syarat')->findOrFail($id);
        $tahunAktif = TahunPelajaran::where('is_active', 1)->first();

        $jalurs = $tahunAktif
            ? JalurPendaftaran::where('tahunPelajaran_id', $tahunAktif->id)
                ->where('is_active', true)
                ->get()
            : collect();

        $syarats = $tahunAktif
            ? SyaratPendaftaran::where('tahunPelajaran_id', $tahunAktif->id)
                ->where('is_active', true)
                ->get()
            : collect();

        return view('admin.kesiswaan.ppdb.formulir_pendaftaran', [
            'formulir'   => $formulir,
            'jalurs'     => $jalurs,
            'tahunAktif' => $tahunAktif,
            'syarats'    => $syarats,
        ]);
    }

    public function update(Request $request, $id)
    {
        $calon = CalonSiswa::findOrFail($id);

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

        $calon->update($validated);

        // update syarat (checkbox)
        if ($request->filled('syarat_id')) {
            $calon->syarat()->sync(
                collect($request->syarat_id)->mapWithKeys(fn($id) => [$id => ['is_checked' => true]])->toArray()
            );
        } else {
            $calon->syarat()->sync([]); // kosongkan jika semua uncheck
        }

        return redirect()->route('admin.kesiswaan.ppdb.daftar-calon-peserta-didik.index')
                         ->with('success', 'Data Calon Peserta didik berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $calon = CalonSiswa::findOrFail($id);
        $calon->delete();

        return redirect()->route('admin.kesiswaan.ppdb.formulir.index')
                         ->with('success', 'Formulir pendaftaran berhasil dihapus.');
    }
}
