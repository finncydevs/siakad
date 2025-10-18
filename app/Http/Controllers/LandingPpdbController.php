<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\TahunPelajaran;
use App\Models\JalurPendaftaran;
use App\Models\Rombel;
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
        $tahunAktif = TahunPelajaran::where('is_active', 1)->first();

        return view('landing.ppdb.beranda', compact('beranda', 'keunggulanList','tahunAktif'));
    }

    public function kompetensiKeahlian() {

        $kompetensiList = KompetensiPpdb::all();
        return view('landing.ppdb.kompetensiKeahlian',compact('kompetensiList'));
    }

    public function daftarCalonSiswa(Request $request) {
        if ($request->ajax()) {
            $tahunAktif = TahunPelajaran::where('is_active', 1)->first();
            if (!$tahunAktif) {
                return response()->json(['applicants' => []]);
            }

            $yearSuffix = substr($tahunAktif->tahun_pelajaran, -2); // ambil 2 digit terakhir tahun akhir, misal '26'

            $applicants = CalonSiswa::where('tahun_id', $tahunAktif->id)
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function($applicant) use ($yearSuffix) {
                    $nomerResi = $applicant->nomor_resi ?? '0';
                    // ambil 3 digit terakhir setelah titik (misal 251018.001 -> 001)
                    $parts = explode('.', $nomerResi);
                    $lastThree = end($parts); 
                    $lastThree = str_pad($lastThree, 3, '0', STR_PAD_LEFT);
                    $applicant->registration_number = 'PPDB'.$yearSuffix.'-'.$lastThree;
                    return $applicant;
                });

            return response()->json(['applicants' => $applicants]);
        }

        return view('landing.ppdb.daftarCalonSiswa');
    }

    public function formulirPendaftaran() {
        $tahunAktif = TahunPelajaran::where('is_active', 1)->first();

        $jurusans = Rombel::select('jurusan_id_str')
            ->distinct()
            ->orderBy('jurusan_id_str')
            ->pluck('jurusan_id_str');

        $jalurs = $tahunAktif
            ? JalurPendaftaran::where('tahunPelajaran_id', $tahunAktif->id)
                ->where('is_active', true)
                ->get()
            : collect();

        return view('landing.ppdb.formulirPendaftaraan',compact('tahunAktif','jalurs', 'jurusans'));
    }

    public function kontak() {
        return view('landing.ppdb.kontak');
    }

    public function submitForm(Request $request) {
        dd($request->all());
    }
}
