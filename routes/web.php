<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilSekolahController;
use App\Http\Controllers\Admin\Kesiswaan\TahunPpdbController;
use App\Http\Controllers\Admin\Kesiswaan\JalurController;
use App\Http\Controllers\Admin\Kesiswaan\QuotaController;
use App\Http\Controllers\Admin\Kesiswaan\SyaratController;
use App\Http\Controllers\Admin\Kesiswaan\FormulirController;
use App\Http\Controllers\Admin\Kesiswaan\DaftarCalonPesertaDidikController;
use App\Http\Controllers\Admin\Kesiswaan\PenempatanKelasController;
use App\Http\Controllers\Admin\Kesiswaan\LaporanPendaftaranController;
use App\Http\Controllers\Admin\Kesiswaan\LaporanQuotaController;
use App\Http\Controllers\Admin\Akademik\TapelController;
use App\Http\Controllers\Admin\Akademik\SemesterController;

Route::get('/', function () {
    return view('welcome');
});

// Tambahkan rute ini
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});
Route::get('/profil-sekolah', [ProfilSekolahController::class, 'edit'])->name('profil-sekolah.edit');
Route::put('/profil-sekolah', [ProfilSekolahController::class, 'update'])->name('profil-sekolah.update');

/*
|--------------------------------------------------------------------------
| Web Routes untuk bagian Kesiswaan -> PPDB
|--------------------------------------------------------------------------
*/

Route::prefix('/admin/kesiswaan/ppdb')->name('admin.ppdb.')->group(function () {

    Route::resource('/tahun-ppdb', tahunPpdbController::class)->names('tahun-ppdb');
    Route::resource('/jalur-ppdb', JalurController::class)->names('jalur-ppdb');
    Route::resource('/quota-ppdb', QuotaController::class)->names('quota-ppdb');
    Route::resource('/syarat-ppdb', SyaratController::class)->names('syarat-ppdb');
    Route::resource('/formulir-ppdb', FormulirController::class)->names('formulir-ppdb');
    Route::resource('/daftar-calon-peserta-didik', DaftarCalonPesertaDidikController::class)->names('daftar-calon-peserta-didik');
    Route::resource('/penempatan-kelas', PenempatanKelasController::class)->names('penempatan-kelas');
    Route::resource('/laporan-pendaftaran', LaporanPendaftaranController::class)->names('laporan-pendaftaran');
    Route::resource('/laporan-quota', LaporanQuotaController::class)->names('laporan-quota');

});

Route::prefix('admin/akademik')->name('admin.akademik.')->group(function () {
    Route::resource('tapel', TapelController::class)->only(['index', 'store', 'destroy']);
    Route::patch('tapel/{tapel}/toggle', [TapelController::class, 'toggleStatus'])->name('tapel.toggle');
    Route::resource('semester', SemesterController::class)->only(['index']);
    Route::patch('semester/{semester}/toggle', [SemesterController::class, 'toggle'])->name('semester.toggle');
});

