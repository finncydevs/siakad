<?php

namespace App\Http\Controllers\Admin\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Tapel;
use Illuminate\Support\Facades\DB;

class TapelController extends Controller
{
    public function index()
    {
        $tapel = Tapel::orderByDesc('kode_tapel')->get();
        return view('admin.akademik.tapel.index', compact('tapel'));
    }

    public function sinkron()
    {
        // Ambil semester_id terbaru dari rombels
        $latest = DB::table('rombels')
            ->select('semester_id')
            ->whereNotNull('semester_id')
            ->distinct()
            ->orderByDesc('semester_id')
            ->first();

        if ($latest) {
            $kode = $latest->semester_id;
            $tahun = substr($kode, 0, 4);
            $semester = substr($kode, -1) == '1' ? 'Ganjil' : 'Genap';
            $tahunAjaran = $tahun.'/'.($tahun+1);

            $existing = Tapel::where('kode_tapel', $kode)->first();

            // Nonaktifkan semua dulu
            Tapel::query()->update(['is_active' => false]);

            if (!$existing) {
                Tapel::create([
                    'kode_tapel' => $kode,
                    'tahun_ajaran' => $tahunAjaran,
                    'semester' => $semester,
                    'is_active' => true,
                ]);
            } else {
                $existing->update(['is_active' => true]);
            }

            return back()->with('success', 'Tapel berhasil disinkron dan diaktifkan 🟢');
        }

        return back()->with('warning', 'Tidak ada data semester_id di tabel rombels ❌');
    }

    public function setAktif($id)
    {
        Tapel::query()->update(['is_active' => false]);
        Tapel::where('id', $id)->update(['is_active' => true]);

        return back()->with('success', 'Tapel berhasil dijadikan aktif 🟢');
    }
}
