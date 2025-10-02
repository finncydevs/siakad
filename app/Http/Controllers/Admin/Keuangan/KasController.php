<?php

namespace App\Http\Controllers\Admin\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\KasMutasi;
use App\Models\MasterKas;
use Illuminate\Http\Request;

class KasController extends Controller
{
    /**
     * Menampilkan halaman buku kas (ledger).
     */
    public function index(Request $request)
    {
        // Ambil semua kas yang aktif untuk dropdown filter
        $daftarKas = MasterKas::where('is_active', true)->get();

        // Coba cari kas yang dipilih dari request, atau ambil kas pertama yang ada sebagai default
        $kasDipilih = $request->filled('kas_id')
            ? $daftarKas->firstWhere('id', $request->kas_id)
            : $daftarKas->first();

        $mutasi = collect(); // Siapkan koleksi kosong sebagai default
        $saldoAwal = 0;

        // HANYA jalankan query jika ada kas yang ditemukan/dipilih
        if ($kasDipilih) {
            $query = KasMutasi::where('master_kas_id', $kasDipilih->id);

            // Logika filter berdasarkan bulan
            if ($request->filled('bulan')) {
                $bulan = substr($request->bulan, 5, 2);
                $tahun = substr($request->bulan, 0, 4);

                // Hitung Saldo Awal: total debit - total kredit dari semua transaksi SEBELUM bulan yang dipilih
                $saldoAwal = KasMutasi::where('master_kas_id', $kasDipilih->id)
                    ->where('tanggal', '<', "$tahun-$bulan-01")
                    ->sum(DB::raw('debit - kredit'));

                $query->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            } else {
                 // Jika tidak ada filter bulan, saldo awal adalah 0 dan ambil semua transaksi
                 $saldoAwal = 0;
            }

            $mutasi = $query->orderBy('tanggal')->orderBy('id')->get();

            // Logika untuk menghitung saldo berjalan (running balance)
            $saldoBerjalan = $saldoAwal;
            $mutasi->transform(function ($item) use (&$saldoBerjalan) {
                $saldoBerjalan += $item->debit;
                $saldoBerjalan -= $item->kredit;
                $item->saldo = $saldoBerjalan;
                return $item;
            });
        }

        return view('admin.keuangan.kas_kecil.index', compact('mutasi', 'kasDipilih', 'daftarKas', 'saldoAwal'));
    }
}
