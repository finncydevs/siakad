<?php
// app/Http/Controllers/ProfilSekolahController.php

namespace App\Http\Controllers;

use App\Models\ProfilSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilSekolahController extends Controller
{
    /**
     * Menampilkan form untuk mengedit profil sekolah.
     */
    public function edit()
    {
        // Ambil data profil sekolah, jika tidak ada, buat baru.
        // Ini memastikan selalu ada 1 baris data di tabel.
        $profil = ProfilSekolah::firstOrCreate(['id' => 1]);
        return view('admin.profil_sekolah.edit', compact('profil'));
    }

    /**
     * Mengupdate data profil sekolah di database.
     */
    public function update(Request $request)
    {
        // Ambil data profil atau buat baru jika belum ada
        $profil = ProfilSekolah::firstOrCreate(['id' => 1]);

        // Ambil semua data dari form
        $data = $request->all();

        // Proses upload Logo
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($profil->logo && Storage::exists('public/' . $profil->logo)) {
                Storage::delete('public/' . $profil->logo);
            }
            $data['logo'] = $request->file('logo')->store('profil', 'public');
        }

        // Proses upload Icon
        if ($request->hasFile('icon')) {
            // Hapus icon lama jika ada
            if ($profil->icon && Storage::exists('public/' . $profil->icon)) {
                Storage::delete('public/' . $profil->icon);
            }
            $data['icon'] = $request->file('icon')->store('profil', 'public');
        }

        // Update data di database
        $profil->update($data);

        // Kembali ke halaman edit dengan pesan sukses
        return redirect()->route('profil-sekolah.edit')->with('success', 'Profil sekolah berhasil diperbarui!');
    }
}