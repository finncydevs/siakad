<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPpdbController extends Controller
{
    // public function beranda() {
    //     return view('interface.beranda');
    // }

    // public function jalurSyarat() {
    //     return view('interface.jalurSyarat');
    // }

    // public function quota() {
    //     return view('interface.quota');
    // }

    // public function kontak() {
    //     return view('interface.kontak');
    // }

    public function beranda() {
        return view('landing.ppdb.beranda');
    }

    public function kompetensiKeahlian() {
        return view('landing.ppdb.kompetensiKeahlian');
    }

    public function daftarCalonSiswa() {
        return view('landing.ppdb.daftarCalonSiswa');
    }

    public function formulirPendaftaran() {
        return view('landing.ppdb.formulirPendaftaraan');
    }

    public function kontak() {
        return view('landing.ppdb.kontak');
    }
}
