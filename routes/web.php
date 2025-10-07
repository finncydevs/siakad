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
use App\Http\Controllers\Admin\Akademik\ProgramKeahlianController;
use App\Http\Controllers\Admin\Akademik\PaketKeahlianController; 
use App\Http\Controllers\Admin\Akademik\JurusanController;
use App\Http\Controllers\Admin\Akademik\MapelController; 
use App\Http\Controllers\Admin\Akademik\EkstrakurikulerController;

// Controller Kesiswaan
use App\Http\Controllers\Admin\Kesiswaan\DaftarCalonPesertaDidikController;
use App\Http\Controllers\Admin\Kesiswaan\FormulirPendaftaranController;
use App\Http\Controllers\Admin\Kesiswaan\JalurController;
use App\Http\Controllers\Admin\Kesiswaan\LaporanPendaftaranController;
use App\Http\Controllers\Admin\Kesiswaan\LaporanQuotaController;
use App\Http\Controllers\Admin\Kesiswaan\PenempatanKelasController;
use App\Http\Controllers\Admin\Kesiswaan\QuotaController;
use App\Http\Controllers\Admin\Kesiswaan\SyaratController;
use App\Http\Controllers\Admin\Kesiswaan\TahunPpdbController;

use App\Http\Controllers\Admin\Settings\ApiSettingsController; // Pastikan ini di-import


/*
|--------------------------------------------------------------------------
| Rute Publik
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('admin.dashboard');
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

    // --- GRUP PENGATURAN ---
    Route::prefix('pengaturan')->name('pengaturan.')->group(function() {
        Route::get('/profil_sekolah', [ProfilSekolahController::class, 'edit'])->name('profil_sekolah.edit');
        Route::put('/profil_sekolah', [ProfilSekolahController::class, 'update'])->name('profil_sekolah.update');
        
        // --- PENGATURAN WEB SERVICE BARU ---
        Route::prefix('webservice')->name('webservice.')->group(function () {
            // Rute ini memanggil ApiSettingsController@index
            Route::get('/', [ApiSettingsController::class, 'index'])->name('index'); 
        });
        // -------------------------------------
    });

    // --- GRUP KEPEGAWAIAN ---
    Route::prefix('kepegawaian')->name('kepegawaian.')->group(function() {
        Route::resource('pegawai', PegawaiController::class);
        Route::resource('tugas-pegawai', TugasPegawaiController::class)->except(['create', 'edit', 'show']);
    });

// --- GRUP AKADEMIK ---
Route::prefix('akademik')->name('akademik.')->group(function () {
    Route::get('tapel', [TapelController::class, 'index'])->name('tapel.index');
    Route::get('tapel/sinkron', [TapelController::class, 'sinkron'])->name('tapel.sinkron');
    Route::post('tapel/aktif/{id}', [TapelController::class, 'setAktif'])->name('tapel.aktif');
    Route::resource('semester', SemesterController::class)->only(['index']);
    Route::patch('semester/{semester}/toggle', [SemesterController::class, 'toggle'])->name('semester.toggle');
    Route::resource('program-keahlian', ProgramKeahlianController::class)->only(['index']);
    Route::resource('paket-keahlian', PaketKeahlianController::class)->only(['index']);
    Route::resource('jurusan', JurusanController::class)->only(['index']);
    Route::get('mapel', [MapelController::class, 'index'])->name('mapel.index'); 
    Route::get('/ekstrakurikuler', [EkstrakurikulerController::class, 'index'])->name('ekskul.index');
});

    // --- GRUP KESISWAAN ---
    Route::prefix('kesiswaan')->name('kesiswaan.')->group(function() {
        // Rute untuk Data Siswa
        Route::resource('siswa', SiswaController::class);

        // Sub-grup untuk PPDB
        Route::prefix('ppdb')->name('ppdb.')->group(function () {
            Route::resource('tahun-ppdb', TahunPpdbController::class);
            Route::post('/tahun-ppdb/{id}/toggle-active', [TahunPpdbController::class, 'toggleActive'])->name('tahun-ppdb.toggleActive');
            Route::resource('jalur-ppdb', JalurController::class);
            Route::post('/jalur-ppdb/{id}/toggle-active', [JalurController::class, 'toggleActive'])->name('jalur-ppdb.toggleActive');
            Route::resource('quota-ppdb', QuotaController::class);
            Route::resource('syarat-ppdb', SyaratController::class);
            Route::post('/syarat-ppdb/{id}/toggle-active', [SyaratController::class, 'toggleActive'])->name('syarat-ppdb.toggleActive');
            Route::resource('formulir-ppdb', FormulirPendaftaranController::class);
            Route::resource('daftar-calon-peserta-didik', DaftarCalonPesertaDidikController::class);
            Route::resource('penempatan-kelas', PenempatanKelasController::class);
            Route::resource('laporan-pendaftaran', LaporanPendaftaranController::class);
            Route::resource('laporan-quota', LaporanQuotaController::class);
        });
        

    });
});