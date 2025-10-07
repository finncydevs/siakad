<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Rombel; // Tambahkan ini untuk mengambil data rombel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar siswa dengan filter berdasarkan rombel.
     */
   public function index(Request $request)
{
    $query = Siswa::query()->with('rombel'); // Eager load relasi rombel

    // 1. Logika untuk Pencarian
    if ($request->filled('search')) {
        $searchTerm = $request->search;
        $query->where(function($q) use ($searchTerm) {
            $q->where('nama', 'like', "%{$searchTerm}%")
              ->orWhere('nis', 'like', "%{$searchTerm}%")
              ->orWhere('nisn', 'like', "%{$searchTerm}%");
        });
    }

    // 2. Logika untuk Filter Kelas
    if ($request->filled('rombel_id')) {
        $query->where('rombongan_belajar_id', $request->rombel_id);
    }

    $siswas = $query->latest()->paginate(10);
    $rombels = Rombel::orderBy('nama')->get(); // Sesuaikan jika nama kolom berbeda

    return view('admin.kesiswaan.siswa.index', compact('siswas', 'rombels'));
}
    public function edit(Siswa $siswa)
    {
        $rombels = Rombel::orderBy('nama')->get();
        return view('admin.kesiswaan.siswa.edit', compact('siswa', 'rombels'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // $data = $request->except(['foto']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $data['foto'] = $request->file('foto')->store('siswa/foto', 'public');
        }
// dd($data);

        $siswa->update($data);

        return redirect()->route('admin.kesiswaan.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

}
