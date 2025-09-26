<?php

namespace App\Http\Controllers;

use App\Models\TugasPegawai;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class TugasPegawaiController extends Controller
{
    public function index()
    {
        $tugasPegawais = TugasPegawai::with('pegawai')->latest()->get();
        $pegawais = Pegawai::orderBy('nama_lengkap', 'asc')->get();
        // Pastikan path ini benar
        return view('admin.kepegawaian.tugas_pegawai.index', compact('tugasPegawais', 'pegawais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'tahun_pelajaran' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
            'tugas_pokok' => 'required|string|max:255',
        ]);

        TugasPegawai::create($request->all());

        return redirect()->route('admin.kepegawaian.tugas-pegawai.index')->with('success', 'Tugas pegawai berhasil ditambahkan.');
    }

    public function update(Request $request, TugasPegawai $tugasPegawai)
    {
         $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'tahun_pelajaran' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
            'tugas_pokok' => 'required|string|max:255',
        ]);

        $tugasPegawai->update($request->all());

        return redirect()->route('admin.kepegawaian.tugas-pegawai.index')->with('success', 'Tugas pegawai berhasil diperbarui.');
    }

    public function destroy(TugasPegawai $tugasPegawai)
    {
        $tugasPegawai->delete();
        return redirect()->route('admin.kepegawaian.tugas-pegawai.index')->with('success', 'Tugas pegawai berhasil dihapus.');
    }
}

