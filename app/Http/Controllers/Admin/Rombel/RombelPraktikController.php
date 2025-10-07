<?php

namespace App\Http\Controllers\Admin\Rombel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class RombelPraktikController extends Controller
{
    /**
     * Menampilkan form untuk membuat data rombel praktik baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.rombel.praktik.create');
    }

    /**
     * Menampilkan halaman utama dengan daftar rombel praktik.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Data dikosongkan untuk tampilan awal
        $dummyData = collect([]);

        // Logika paginasi untuk data kosong
        $perPage = 10;
        $currentPage = request()->input('page', 1);
        $pagedData = $dummyData->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $rombels = new LengthAwarePaginator($pagedData, count($dummyData), $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        return view('admin.rombel.praktik.index', compact('rombels'));
    }
}