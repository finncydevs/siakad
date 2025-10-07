<?php

namespace App\Http\Controllers\Admin\Rombel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class RombelRegulerController extends Controller
{
    /**
     * Menampilkan form untuk membuat data rombel baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Method ini hanya bertugas menampilkan halaman form
        return view('admin.rombel.reguler.create');
    }

    /**
     * Menampilkan halaman utama dengan daftar rombel reguler.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Data masih dikosongkan sesuai permintaan sebelumnya
        $dummyData = collect([]);
        
        // Logika paginasi
        $perPage = 10;
        $currentPage = request()->input('page', 1);
        $pagedData = $dummyData->slice(($currentPage - 1) * $perPage, $perPage)->all();
        
        $rombels = new LengthAwarePaginator($pagedData, count($dummyData), $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);
        
        return view('admin.rombel.reguler.index', compact('rombels'));
    }
}