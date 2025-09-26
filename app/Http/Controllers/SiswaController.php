<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::query();
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_aktif_id', $request->kelas_id);
        }
        $siswas = $query->latest()->get();
        // Data kelas dummy untuk filter
        $kelas = [1 => 'Kelas X-A', 2 => 'Kelas X-B', 3 => 'Kelas XI-A']; 
        return view('admin.kesiswaan.siswa.index', compact('siswas', 'kelas'));
    }

    public function create()
    {
        return view('admin.kesiswaan.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama_lengkap' => 'required|string|max:255']);

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
        return view('admin.kesiswaan.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate(['nama_lengkap' => 'required|string|max:255']);

        $data = $request->except(['foto']);

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $data['foto'] = $request->file('foto')->store('siswa/foto', 'public');
        }

        $siswa->fill($data);

        if ($siswa->isDirty()) {
            $siswa->save();
            return redirect()->route('admin.kesiswaan.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
        } else {
            return redirect()->route('admin.kesiswaan.siswa.index')->with('info', 'Anda tidak mengubah data apapun.');
        }
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }
        
        $siswa->delete();

        return redirect()->route('admin.kesiswaan.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}

