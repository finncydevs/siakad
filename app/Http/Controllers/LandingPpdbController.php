<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BerandaPpdb;
use App\Models\KeunggulanPpdb;
use App\Models\KompetensiPpdb;
use App\Models\ProfilSekolah;

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

        $beranda = BerandaPpdb::first();
        $keunggulanList = KeunggulanPpdb::all();

        return view('landing.ppdb.beranda', compact('beranda', 'keunggulanList'));
    }

    public function kompetensiKeahlian() {

        $kompetensiList = KompetensiPpdb::all();
        return view('landing.ppdb.kompetensiKeahlian',compact('kompetensiList'));
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
