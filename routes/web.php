<?php

use Illuminate\Support\Facades\Route;

// Controller Utama
use App\Http\Controllers\ProfilSekolahController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\TugasPegawaiController; // Ditambahkan

// Controller Kesiswaan (Namespace diperbaiki untuk kerapian)
use App\Http\Controllers\Admin\Kesiswaan\DaftarCalonPesertaDidikController;
use App\Http\Controllers\Admin\Kesiswaan\FormulirController;
use App\Http\Controllers\Admin\Kesiswaan\JalurController;
use App\Http\Controllers\Admin\Kesiswaan\LaporanPendaftaranController;
use App\Http\Controllers\Admin\Kesiswaan\LaporanQuotaController;
use App\Http\Controllers\Admin\Akademik\TapelController;
use App\Http\Controllers\Admin\Akademik\SemesterController;

/*
|--------------------------------------------------------------------------
| Rute Publik (Landing Page, dll)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Rute Panel Admin
|--------------------------------------------------------------------------
|
| Semua rute di sini akan memiliki prefix URL /admin
| Contoh: /admin/dashboard, /admin/pegawai, /admin/kesiswaan/ppdb/jalur-ppdb
|
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // --- PENGATURAN UMUM ---
    Route::get('/profil-sekolah', [ProfilSekolahController::class, 'edit'])->name('profil-sekolah.edit');
    Route::put('/profil-sekolah', [ProfilSekolahController::class, 'update'])->name('profil-sekolah.update');


    // --- KEPEGAWAIAN ---
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('tugas-pegawai', TugasPegawaiController::class)->except(['create', 'edit', 'show']);


    // --- KESISWAAN ---
    Route::prefix('kesiswaan/ppdb')->name('ppdb.')->group(function () {
        Route::resource('tahun-ppdb', TahunPpdbController::class);
        Route::resource('jalur-ppdb', JalurController::class);
        Route::resource('quota-ppdb', QuotaController::class);
        Route::resource('syarat-ppdb', SyaratController::class);
        Route::resource('formulir-ppdb', FormulirController::class);
        Route::resource('daftar-calon-peserta-didik', DaftarCalonPesertaDidikController::class);
        Route::resource('penempatan-kelas', PenempatanKelasController::class);
        Route::resource('laporan-pendaftaran', LaporanPendaftaranController::class);
        Route::resource('laporan-quota', LaporanQuotaController::class);
    });

     Route::prefix('akademik')->name('akademik.')->group(function () {
    Route::resource('tapel', TapelController::class)->only(['index', 'store', 'destroy']);
    Route::patch('tapel/{tapel}/toggle', [TapelController::class, 'toggleStatus'])->name('tapel.toggle');
    Route::resource('semester', SemesterController::class)->only(['index']);
    Route::patch('semester/{semester}/toggle', [SemesterController::class, 'toggle'])->name('semester.toggle');
});

});