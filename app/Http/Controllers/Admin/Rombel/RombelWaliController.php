<?php

namespace App\Http\Controllers\Admin\Rombel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class RombelWaliController extends Controller
{
    /**
     * Menampilkan form untuk menambah data wali kelas.
     */
    public function create()
    {
        return view('admin.rombel.wali.create');
    }

    /**
     * Menampilkan halaman utama dengan daftar wali kelas.
     */
    public function index()
    {
        $data = collect([]); // Data dikosongkan

        $perPage = 10;
        $currentPage = request()->input('page', 1);
        $pagedData = $data->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $walis = new LengthAwarePaginator($pagedData, count($data), $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        return view('admin.rombel.wali.index', compact('walis'));
    }
}