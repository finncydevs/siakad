<?php

namespace App\Http\Controllers\Admin\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = DB::table('rombels')
            ->select('jurusan_id', 'jurusan_id_str')
            ->distinct()
            ->orderBy('jurusan_id_str')
            ->get();

        $kodeJurusan = [
            'Pengembangan Perangkat Lunak dan Gim' => 'PPLG',
            'Manajemen Perkantoran dan Layanan Bisnis' => 'MPLB',
            'Akuntansi dan Keuangan Lembaga' => 'AKL',
            'Desain Komunikasi Visual' => 'DKV',
            'Teknik Otomotif' => 'TET',
            'Teknik Mesin' => 'TET',
            'Teknik Komputer dan Jaringan' => 'TKJ',
            'Multi Media' => 'MM',
            'Pendidikan Agama Islam' => 'PAI',
            'Seni Teater' => 'ST',
        ];

        $jurusan = $jurusan->map(function ($item) use ($kodeJurusan) {
            $item->kode = $kodeJurusan[$item->jurusan_id_str] ?? '???';
            return $item;
        });

        return view('admin.akademik.jurusan.index', compact('jurusan'));
    }
}
