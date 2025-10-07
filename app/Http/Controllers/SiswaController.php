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

        // Filter berdasarkan rombongan belajar jika ada input
        if ($request->filled('rombel_id')) {
            $query->where('rombongan_belajar_id', $request->rombel_id);
        }

        $siswas = $query->latest()->get();

        // Ambil data rombel dari database untuk filter dropdown
        $rombels = Rombel::orderBy('nama_rombel')->get();

        return view('admin.kesiswaan.siswa.index', compact('siswas', 'rombels'));
    }

    public function create()
    {
        $rombels = Rombel::orderBy('nama_rombel')->get();
        return view('admin.kesiswaan.siswa.create', compact('rombels'));
    }

    /**
     * Menyimpan data siswa baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'nullable|string|max:20|unique:siswas,nis',
            'nisn' => 'nullable|string|max:20|unique:siswas,nisn',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'rombongan_belajar_id' => 'nullable|exists:rombels,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['foto']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswa/foto', 'public');
        }

        Siswa::create($data);

        return redirect()->route('admin.kesiswaan.siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show(Siswa $siswa)
    {
        return view('admin.kesiswaan.siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        $rombels = Rombel::orderBy('nama_rombel')->get();
        return view('admin.kesiswaan.siswa.edit', compact('siswa', 'rombels'));
    }

    /**
     * Memperbarui data siswa.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => ['nullable', 'string', 'max:20', Rule::unique('siswas')->ignore($siswa->id)],
            'nisn' => ['nullable', 'string', 'max:20', Rule::unique('siswas')->ignore($siswa->id)],
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'rombongan_belajar_id' => 'nullable|exists:rombels,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['foto']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $data['foto'] = $request->file('foto')->store('siswa/foto', 'public');
        }

        $siswa->update($data);

        return redirect()->route('admin.kesiswaan.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Menghapus data siswa.
     */
    public function destroy(Siswa $siswa)
    {
        // Hapus foto dari storage
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->delete();

        return redirect()->route('admin.kesiswaan.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
