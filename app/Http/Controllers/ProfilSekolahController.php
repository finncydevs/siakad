<?php

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
        $profil = ProfilSekolah::firstOrCreate(['id' => 1]);
        // PERBAIKAN: Menyesuaikan path view agar konsisten dengan grup rute
        return view('admin.pengaturan.profil_sekolah.edit', compact('profil'));
    }

    /**
     * Mengupdate data profil sekolah di database.
     */
    public function update(Request $request)
    {
        $profil = ProfilSekolah::firstOrCreate(['id' => 1]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            if ($profil->logo && Storage::exists('public/' . $profil->logo)) {
                Storage::delete('public/' . $profil->logo);
            }
            $data['logo'] = $request->file('logo')->store('profil', 'public');
        }

        if ($request->hasFile('icon')) {
            if ($profil->icon && Storage::exists('public/' . $profil->icon)) {
                Storage::delete('public/' . $profil->icon);
            }
            $data['icon'] = $request->file('icon')->store('profil', 'public');
        }

        $profil->update($data);

        // PERBAIKAN: Menyesuaikan nama rute untuk redirect
        return redirect()->route('admin.pengaturan.profil-sekolah.edit')->with('success', 'Profil sekolah berhasil diperbarui!');
    }
}
