<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        // Logika untuk filter per kelas (sementara pakai data dummy)
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
        // PERBAIKAN: Menyesuaikan path view
        return view('admin.kesiswaan.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama_lengkap' => 'required']);
        // Logika penyimpanan akan sangat kompleks, kita buat dasarnya dulu
        Siswa::create($request->all());
        // PERBAIKAN: Menyesuaikan nama rute
        return redirect()->route('admin.kesiswaan.siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show(Siswa $siswa)
    {
        // PERBAIKAN: Menyesuaikan path view
        return view('admin.kesiswaan.siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        // PERBAIKAN: Menyesuaikan path view
        return view('admin.kesiswaan.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate(['nama_lengkap' => 'required']);
        $siswa->update($request->all());
        // PERBAIKAN: Menyesuaikan nama rute
        return redirect()->route('admin.kesiswaan.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        // PERBAIKAN: Menyesuaikan nama rute
        return redirect()->route('admin.kesiswaan.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}

