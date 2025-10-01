<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use App\Models\AbsensiSiswa;
use App\Models\Rombel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanAbsensiController extends Controller
{
    public function index(Request $request)
    {
        // --- PERBAIKAN DI SINI ---
        // Ambil semua rombel, lalu saring agar namanya unik.
        $rombels = Rombel::orderBy('nama', 'asc')->get()->unique('nama');
        // --- AKHIR PERBAIKAN ---

        // Tentukan rentang tanggal default (bulan ini)
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // Mulai query absensi siswa dengan data relasinya
        $query = AbsensiSiswa::with(['siswa.rombel'])
                    ->whereBetween('tanggal', [$startDate, $endDate]);

        // Terapkan filter jika ada
        if ($request->filled('rombel_id')) {
            // Perbaikan kecil: Filter berdasarkan rombongan_belajar_id yang unik
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('rombongan_belajar_id', $request->rombel_id);
            });
        }
        if ($request->filled('status')) {
            if ($request->status == 'Terlambat') {
                $query->where('status_kehadiran', 'Terlambat');
            } else {
                $query->where('status', $request->status);
            }
        }
        
        // Ambil hasil query dengan paginasi
        $laporanAbsensi = $query->orderBy('tanggal', 'desc')->paginate(25);

        // Buat data rekapitulasi (summary)
        $rekap = [
            'hadir' => (clone $query)->where('status', 'Hadir')->count(),
            'sakit' => (clone $query)->where('status', 'Sakit')->count(),
            'izin' => (clone $query)->where('status', 'Izin')->count(),
            'alfa' => (clone $query)->where('status', 'Alfa')->count(),
            'terlambat' => (clone $query)->where('status_kehadiran', 'Terlambat')->count(),
        ];

        return view('admin.laporan.absensi.index', compact('laporanAbsensi', 'rombels', 'startDate', 'endDate', 'rekap'));
    }

    public function export(Request $request)
    {
        // Logika untuk ekspor ke Excel akan ditambahkan di sini.
        // Ini memerlukan package tambahan seperti Maatwebsite/Excel.
        // Untuk saat ini, kita bisa redirect kembali dengan pesan.
        return back()->with('info', 'Fitur ekspor sedang dalam pengembangan.');
    }
}
