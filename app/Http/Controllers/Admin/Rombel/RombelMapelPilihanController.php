<?php

namespace App\Http\Controllers\Admin\Rombel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class RombelMapelPilihanController extends Controller
{
    /**
     * Menampilkan form untuk membuat data mapel pilihan baru.
     */
    public function create()
    {
        return view('admin.rombel.mapel-pilihan.create');
    }

    /**
     * Menampilkan halaman utama dengan daftar mapel pilihan.
     */
    public function index()
    {
        $data = collect([]); // Data dikosongkan

        $perPage = 10;
        $currentPage = request()->input('page', 1);
        $pagedData = $data->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $rombels = new LengthAwarePaginator($pagedData, count($data), $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        return view('admin.rombel.mapel-pilihan.index', compact('rombels'));
    }
}