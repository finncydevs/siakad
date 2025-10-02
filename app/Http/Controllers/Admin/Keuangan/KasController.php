<?php

namespace App\Http\Controllers\Admin\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\KasMutasi; // Buat model ini
use App\Models\MasterKas;
use Illuminate\Http\Request;

class KasController extends Controller
{
    public function index(Request $request)
    {
        $kasDipilih = MasterKas::find($request->get('kas_id', 1)); // Ambil kas pertama sebagai default

        $query = KasMutasi::where('master_kas_id', $kasDipilih->id);

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', substr($request->bulan, 5, 2))
                  ->whereYear('tanggal', substr($request->bulan, 0, 4));
        }

        $mutasi = $query->orderBy('tanggal')->orderBy('id')->get();

        $saldo = 0;
        $mutasi->transform(function ($item) use (&$saldo) {
            $saldo += $item->debit;
            $saldo -= $item->kredit;
            $item->saldo = $saldo;
            return $item;
        });

        return view('admin.keuangan.kas_kecil.index', compact('mutasi', 'kasDipilih'));
    }
}
