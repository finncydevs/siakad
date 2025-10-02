<?php

use Illuminate\Support\Facades\Route;

// Controller Utama
use App\Http\Controllers\ProfilSekolahController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\TugasPegawaiController;
use App\Http\Controllers\SiswaController;

// Controller Akademik
use App\Http\Controllers\Admin\Akademik\SemesterController;
use App\Http\Controllers\Admin\Akademik\TapelController;

// Controller Kesiswaan
use App\Http\Controllers\Admin\Kesiswaan\ppdb\DaftarPesertaDidikBaruController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\DaftarCalonPesertaDidikController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\FormulirPendaftaranController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\JalurController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\LaporanPendaftaranController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\LaporanQuotaController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\PenempatanKelasController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\QuotaController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\SyaratController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\TahunPpdbController;

use App\Http\Controllers\Admin\Settings\ApiSettingsController; // Pastikan ini di-import


/*
|--------------------------------------------------------------------------
| Rute Publik
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Rute Panel Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::prefix('pengaturan')->name('pengaturan.')->group(function() {
        Route::get('/profil_sekolah', [ProfilSekolahController::class, 'edit'])->name('profil_sekolah.edit');
        Route::put('/profil_sekolah', [ProfilSekolahController::class, 'update'])->name('profil_sekolah.update');

        Route::prefix('webservice')->name('webservice.')->group(function () {
            Route::get('/', [ApiSettingsController::class, 'index'])->name('index');
        });
    });

    Route::prefix('kepegawaian')->name('kepegawaian.')->group(function() {
        Route::resource('pegawai', PegawaiController::class);
        Route::resource('tugas-pegawai', TugasPegawaiController::class)->except(['create', 'edit', 'show']);
    });

    // --- GRUP AKADEMIK ---
    Route::prefix('akademik')->name('akademik.')->group(function () {
        Route::resource('tapel', TapelController::class)->only(['index', 'store', 'destroy']);
        Route::patch('tapel/{tapel}/toggle', [TapelController::class, 'toggleStatus'])->name('tapel.toggle');
        Route::resource('semester', SemesterController::class)->only(['index']);
        Route::patch('semester/{semester}/toggle', [SemesterController::class, 'toggle'])->name('semester.toggle');
    });

    /*
    |--------------------------------------------------------------------------
    | Kesiswaan
    |--------------------------------------------------------------------------
    */
    Route::prefix('kesiswaan')->name('kesiswaan.')->group(function() {
        Route::resource('siswa', SiswaController::class);
        
        /*
        |--------------------------------------------------------------------------
        | Kesiswaan (PPDB)
        |--------------------------------------------------------------------------
        */
        Route::prefix('ppdb')->name('ppdb.')->group(function () {
            // Tahun Pelajaran PPDB
            Route::resource('tahun-ppdb', TahunPpdbController::class);
            Route::post('/tahun-ppdb/{id}/toggle-active', [TahunPpdbController::class, 'toggleActive'])->name('tahun-ppdb.toggleActive');

            // Jalur Pendaftaran
            Route::resource('jalur-ppdb', JalurController::class);
            Route::post('/jalur-ppdb/{id}/toggle-active', [JalurController::class, 'toggleActive'])->name('jalur-ppdb.toggleActive');

            // Quota Pendaftaran
            Route::resource('quota-ppdb', QuotaController::class);

            // Syarat Pendaftaran
            Route::resource('syarat-ppdb', SyaratController::class);
            Route::post('/syarat-ppdb/{id}/toggle-active', [SyaratController::class, 'toggleActive'])->name('syarat-ppdb.toggleActive');

            // Formulir Pendaftaran
            Route::resource('formulir-ppdb', FormulirPendaftaranController::class);
            

            Route::get('/get-syarat/{jalurId}', function ($jalurId) {
    $syarat = \App\Models\SyaratPendaftaran::where('jalurPendaftaran_id', $jalurId)
                ->where('is_active', 1)
                ->get(['id','syarat']);
    return response()->json($syarat);
});




            // Data Peserta Didik
            Route::resource('daftar-calon-peserta-didik', DaftarCalonPesertaDidikController::class);
            Route::resource('daftar-peserta-didik-baru', DaftarPesertaDidikBaruController::class);

            // Penempatan Kelas
            Route::resource('penempatan-kelas', PenempatanKelasController::class);

            // Laporan
            Route::resource('laporan-pendaftaran', LaporanPendaftaranController::class);
            Route::resource('laporan-quota', LaporanQuotaController::class);


        });



    });
    Route::prefix('keuangan')->name('keuangan.')->group(function () {
 Route::get('/penerimaan', [PembayaranController::class, 'index'])->name('penerimaan.index');
 Route::post('/penerimaan', [PembayaranController::class, 'store'])->name('penerimaan.store');
 Route::get('/kas', [KasController::class, 'index'])->name('kas.index');
 Route::resource('/iuran', IuranController::class)->except(['create', 'edit', 'show']);
 Route::resource('/voucher', VoucherController::class)->only(['index', 'store', 'destroy']);
 Route::resource('/pengeluaran', PengeluaranController::class)->except(['create', 'edit', 'show']);
});
});
