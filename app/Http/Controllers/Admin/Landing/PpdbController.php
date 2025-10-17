<?php

namespace App\Http\Controllers\Admin\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BerandaPpdb;
use App\Models\KeunggulanPpdb;
use App\Models\KompetensiPpdb;
use App\Models\CalonSiswa;
use App\Models\SyaratPendaftaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PpdbController extends Controller
{
    public function index()
    {
        $beranda = BerandaPpdb::first();
        $keunggulanList = KeunggulanPpdb::all();
        $kompetensiList = KompetensiPpdb::all();

        return view('admin.pengaturan.ppdb.landingPpdb', compact('beranda', 'keunggulanList', 'kompetensiList'));
    }

    public function store(Request $request)
    {
        // BERANDA
        $beranda = BerandaPpdb::first() ?? new BerandaPpdb();
        $beranda->slogan_utama = $request->slogan_utama;
        $beranda->deskripsi_singkat = $request->deskripsi_singkat;
        $beranda->point_keunggulan_1 = $request->point_keunggulan_1;
        $beranda->save();
    
        // KEUNGGULAN
        $idKeunggulan = $request->id_keunggulan ?? [];
        $judulItem = $request->judul_item ?? [];
        $deskripsiItem = $request->deskripsi_item ?? [];
        $icons = $request->icon_keunggulan ?? [];
        $deleteKeunggulan = $request->delete_keunggulan ?? [];
        $judulKeunggulan = $request->judul_keunggulan;
        $deskripsiKeunggulan = $request->deskripsi_keunggulan;
    
        foreach ($judulItem as $i => $judul) {
            $id = $idKeunggulan[$i] ?? null;
            $delete = $deleteKeunggulan[$i] ?? 0;
        
            if ($id && $delete) {
                $keunggulan = KeunggulanPpdb::find($id);
                if($keunggulan){
                    if($keunggulan->icon) Storage::disk('public')->delete($keunggulan->icon);
                    $keunggulan->delete();
                }
                continue;
            }
        
            $keunggulan = $id ? KeunggulanPpdb::find($id) : new KeunggulanPpdb();
            $keunggulan->judul_keunggulan = $judulKeunggulan;
            $keunggulan->deskripsi_keunggulan = $deskripsiKeunggulan;
            $keunggulan->judul_item = $judul;
            $keunggulan->deskripsi_item = $deskripsiItem[$i] ?? '';
        
            if (isset($icons[$i]) && $icons[$i] && $icons[$i]->isValid()) {
                if($keunggulan->icon) Storage::disk('public')->delete($keunggulan->icon);
                $keunggulan->icon = $icons[$i]->store('keunggulan_icons', 'public');
            }
        
            $keunggulan->save();
        }
    
        // KOMPETENSI
        $idKompetensi = $request->id_kompetensi ?? [];
        $namaKompetensi = $request->nama_kompetensi ?? [];
        $kodeKompetensi = $request->kode_kompetensi ?? [];
        $deskripsiJurusan = $request->deskripsi_jurusan ?? [];
        $iconKompetensi = $request->icon_kompetensi ?? [];
        $deleteKompetensi = $request->delete_kompetensi ?? [];
        $judulKompetensi = $request->judul_kompetensi;
        $deskripsiKompetensi = $request->deskripsi_kompetensi;
    
        foreach ($namaKompetensi as $i => $nama) {
            $id = $idKompetensi[$i] ?? null;
            $delete = $deleteKompetensi[$i] ?? 0;
        
            if ($id && $delete) {
                $kompetensi = KompetensiPpdb::find($id);
                if($kompetensi){
                    if($kompetensi->icon) Storage::disk('public')->delete($kompetensi->icon);
                    $kompetensi->delete();
                }
                continue;
            }
        
            $kompetensi = $id ? KompetensiPpdb::find($id) : new KompetensiPpdb();
            $kompetensi->judul_kompetensi = $judulKompetensi;
            $kompetensi->deskripsi_kompetensi = $deskripsiKompetensi;
            $kompetensi->nama_kompetensi = $nama;
            $kompetensi->kode_kompetensi = $kodeKompetensi[$i] ?? '';
            $kompetensi->deskripsi_jurusan = $deskripsiJurusan[$i] ?? '';
        
            if (isset($iconKompetensi[$i]) && $iconKompetensi[$i] && $iconKompetensi[$i]->isValid()) {
                if($kompetensi->icon) Storage::disk('public')->delete($kompetensi->icon);
                $kompetensi->icon = $iconKompetensi[$i]->store('kompetensi_icons', 'public');
            }
        
            $kompetensi->save();
        }
    
        return back()->with('success', 'Data Landing PPDB berhasil disimpan.');
    }

    public function submitForm(Request $request)
    {
        // 1. Validasi data
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'nullable|digits:10',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tempat_lahir' => 'nullable|string|max:255',
            'tgl_lahir' => 'nullable|date',
            'kontak' => 'nullable|string|max:20',
            'asal_sekolah' => 'nullable|string|max:255',
            'kelas' => 'nullable|string|max:50',
            'jurusan' => 'nullable|string|max:50',
            'ukuran_pakaian' => 'nullable|string|max:10',

            // File upload
            'upload-kk' => 'required|file|mimes:pdf,jpeg,png,jpg|max:1024',
            'upload-rapor' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:1024',
            'upload-sertifikat' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:1024',
        ]);

        // 2. Simpan data calon siswa
        $calon = CalonSiswa::create([
            'tahun_id' => 1, // sesuaikan
            'jalur_id' => 1, // sesuaikan
            'nama_lengkap' => $validated['nama_lengkap'],
            'nisn' => $validated['nisn'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'tempat_lahir' => $validated['tempat_lahir'] ?? null,
            'tgl_lahir' => $validated['tgl_lahir'] ?? null,
            'kontak' => $validated['kontak'] ?? null,
            'asal_sekolah' => $validated['asal_sekolah'] ?? null,
            'kelas' => $validated['kelas'] ?? null,
            'jurusan' => $validated['jurusan'] ?? null,
            'ukuran_pakaian' => $validated['ukuran_pakaian'] ?? null,
            'nomor_resi' => 'PPDB-' . Str::upper(Str::random(6)),
        ]);

        // 3. Simpan file upload & pivot syarat
        $syaratFiles = ['upload-kk', 'upload-rapor', 'upload-sertifikat'];

        foreach ($syaratFiles as $inputName) {
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                $path = $file->store('public/ppdb_files');

                // Ambil syarat_id dari tabel syarat_pendaftarans
                $syarat = SyaratPendaftaran::where('name', $inputName)->first();
                if ($syarat) {
                    $calon->syarat()->attach($syarat->id, [
                        'is_checked' => true,
                        'file_path' => $path
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Pendaftaran berhasil dikirim!');
    }

}
