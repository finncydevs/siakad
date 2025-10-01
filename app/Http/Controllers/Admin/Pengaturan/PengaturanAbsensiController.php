<?php

namespace App\Http\Controllers\Admin\Pengaturan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaturanAbsensiController extends Controller
{
    public function edit()
    {
        // Ambil data pengaturan
        $pengaturan = DB::table('pengaturan_absensi')->first();

        // Jika tabel masih kosong, buat baris pengaturan default
        if (!$pengaturan) {
            DB::table('pengaturan_absensi')->insert([
                'jam_masuk_sekolah' => '07:00:00',
                'jam_pulang_sekolah' => '15:00:00',
                'batas_toleransi_terlambat' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // Ambil lagi data yang baru saja dibuat
            $pengaturan = DB::table('pengaturan_absensi')->first();
        }

        return view('admin.pengaturan.absensi.edit', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'jam_masuk_sekolah' => 'required',
            'jam_pulang_sekolah' => 'required',
            'batas_toleransi_terlambat' => 'required|integer|min:0',
        ]);

        // Selalu update baris pertama
        DB::table('pengaturan_absensi')->where('id', 1)->update([
            'jam_masuk_sekolah' => $request->jam_masuk_sekolah,
            'jam_pulang_sekolah' => $request->jam_pulang_sekolah,
            'batas_toleransi_terlambat' => $request->batas_toleransi_terlambat,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Pengaturan absensi berhasil diperbarui.');
    }
}

