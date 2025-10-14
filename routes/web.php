<?php

use Illuminate\Support\Facades\Route;

// --- GROUP CONTROLLER UTAMA ---
use App\Http\Controllers\ProfilSekolahController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\TugasPegawaiController;
use App\Http\Controllers\Admin\Kesiswaan\SiswaController;

// --- GROUP CONTROLLER AKADEMIK ---
use App\Http\Controllers\Admin\Akademik\SemesterController;
use App\Http\Controllers\Admin\Akademik\TapelController;
use App\Http\Controllers\Admin\Akademik\JadwalPelajaranController;
use App\Http\Controllers\Admin\Akademik\JurusanController; // Ditambahkan

// --- GROUP CONTROLLER KESISWAAN ---
use App\Http\Controllers\Admin\Kesiswaan\DaftarCalonPesertaDidikController;
use App\Http\Controllers\Admin\Kesiswaan\FormulirPendaftaranController;
use App\Http\Controllers\Admin\Kesiswaan\JalurController;
use App\Http\Controllers\Admin\Kesiswaan\LaporanPendaftaranController;
use App\Http\Controllers\Admin\Kesiswaan\LaporanQuotaController;
use App\Http\Controllers\Admin\Kesiswaan\PenempatanKelasController;
use App\Http\Controllers\Admin\Kesiswaan\QuotaController;
use App\Http\Controllers\Admin\Kesiswaan\SyaratController;
use App\Http\Controllers\Admin\Kesiswaan\TahunPpdbController;

// --- GROUP CONTROLLER ABSENSI & PENGATURANNYA ---
use App\Http\Controllers\Admin\Absensi\AbsensiSiswaController;
use App\Http\Controllers\Admin\Absensi\IzinSiswaController;
use App\Http\Controllers\Guru\GuruAbsensiController;
use App\Http\Controllers\Admin\Pengaturan\HariLiburController;
use App\Http\Controllers\Admin\Pengaturan\PengaturanAbsensiController;
use App\Http\Controllers\Admin\Laporan\LaporanAbsensiController; // Ditambahkan

// --- GROUP CONTROLLER INDISIPLINER ---
use App\Http\Controllers\Admin\Indisipliner\IndisiplinerSiswaController;

// --- GROUP CONTROLLER PENGATURAN LAINNYA ---
use App\Http\Controllers\Admin\Settings\ApiSettingsController;

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
| Rute Panel Guru
|--------------------------------------------------------------------------
*/
Route::prefix('guru')->middleware(['auth'])->name('guru.')->group(function () {
    Route::get('/absensi', [GuruAbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/kelas/{jadwal}', [GuruAbsensiController::class, 'show'])->name('absensi.show');
    Route::post('/absensi/kelas', [GuruAbsensiController::class, 'store'])->name('absensi.store');
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

    // --- GRUP PENGATURAN (Digabungkan) ---
    Route::prefix('pengaturan')->name('pengaturan.')->group(function() {
        // Profil Sekolah
        Route::get('/profil_sekolah', [ProfilSekolahController::class, 'edit'])->name('profil_sekolah.edit');
        Route::put('/profil_sekolah', [ProfilSekolahController::class, 'update'])->name('profil_sekolah.update');
        
        // Web Service
        Route::prefix('webservice')->name('webservice.')->group(function () {
            Route::get('/', [ApiSettingsController::class, 'index'])->name('index');
        });

        // Pengaturan Absensi
        Route::get('absensi', [PengaturanAbsensiController::class, 'edit'])->name('absensi.edit');
        Route::put('absensi', [PengaturanAbsensiController::class, 'update'])->name('absensi.update');

        // Manajemen Hari Libur
        Route::resource('hari-libur', HariLiburController::class)->except(['show', 'edit', 'update']);
    });
    
    // --- GRUP KEPEGAWAIAN ---
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
        
        // Menambahkan rute jurusan yang hilang
        Route::resource('jurusan', JurusanController::class)->only(['index']);

        Route::get('jadwal', [JadwalPelajaranController::class, 'index'])->name('jadwal.index');
        Route::get('jadwal/{rombel}/edit', [JadwalPelajaranController::class, 'edit'])->name('jadwal.edit');
        Route::post('jadwal', [JadwalPelajaranController::class, 'store'])->name('jadwal.store');
        Route::delete('jadwal/{jadwal}', [JadwalPelajaranController::class, 'destroy'])->name('jadwal.destroy');
    });

    // --- GRUP ABSENSI ---
    Route::prefix('absensi')->name('absensi.')->group(function () {
        Route::prefix('siswa')->name('siswa.')->group(function() {
            Route::get('/', [AbsensiSiswaController::class, 'index'])->name('index');
            Route::get('/form', [AbsensiSiswaController::class, 'show'])->name('show_form');
            Route::post('/', [AbsensiSiswaController::class, 'store'])->name('store');
            Route::get('/scanner', [AbsensiSiswaController::class, 'showScanner'])->name('show_scanner');
            Route::post('/handle-scan', [AbsensiSiswaController::class, 'handleScan'])->name('handle_scan');
            Route::get('/todays-scans', [AbsensiSiswaController::class, 'getTodaysScans'])->name('get_todays_scans');
        });
        Route::resource('izin-siswa', IzinSiswaController::class);
    });
    
    // --- GRUP KESISWAAN ---
    Route::prefix('kesiswaan')->name('kesiswaan.')->group(function() {
        Route::get('/siswa/{siswa}/cetak-kartu', [SiswaController::class, 'cetakKartu'])->name('siswa.cetak_kartu');
        Route::get('/cetak-kartu-massal', [SiswaController::class, 'showCetakMassalIndex'])->name('siswa.cetak_massal_index');
        Route::get('/cetak-kartu-massal/{rombel}', [SiswaController::class, 'cetakKartuMassal'])->name('siswa.cetak_massal_show');
        Route::resource('siswa', SiswaController::class);
        
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

    // --- GRUP INDISIPLINER SISWA ---
    Route::prefix('indisipliner-siswa')->name('indisipliner.siswa.')->group(function () {
        Route::get('pengaturan', [IndisiplinerSiswaController::class, 'pengaturanIndex'])->name('pengaturan.index');
        Route::post('pengaturan/kategori', [IndisiplinerSiswaController::class, 'storeKategori'])->name('pengaturan.kategori.store');
        Route::put('pengaturan/kategori/{pelanggaranKategori}', [IndisiplinerSiswaController::class, 'updateKategori'])->name('pengaturan.kategori.update');
        Route::delete('pengaturan/kategori/{pelanggaranKategori}', [IndisiplinerSiswaController::class, 'destroyKategori'])->name('pengaturan.kategori.destroy');
        Route::post('pengaturan/poin', [IndisiplinerSiswaController::class, 'storePoin'])->name('pengaturan.poin.store');
        Route::put('pengaturan/poin/{pelanggaranPoin}', [IndisiplinerSiswaController::class, 'updatePoin'])->name('pengaturan.poin.update');
        Route::delete('pengaturan/poin/{pelanggaranPoin}', [IndisiplinerSiswaController::class, 'destroyPoin'])->name('pengaturan.poin.destroy');
        Route::post('pengaturan/sanksi', [IndisiplinerSiswaController::class, 'storeSanksi'])->name('pengaturan.sanksi.store');
        Route::put('pengaturan/sanksi/{pelanggaranSanksi}', [IndisiplinerSiswaController::class, 'updateSanksi'])->name('pengaturan.sanksi.update');
        Route::delete('pengaturan/sanksi/{pelanggaranSanksi}', [IndisiplinerSiswaController::class, 'destroySanksi'])->name('pengaturan.sanksi.destroy');
        Route::get('daftar', [IndisiplinerSiswaController::class, 'daftarIndex'])->name('daftar.index');
        Route::post('daftar', [IndisiplinerSiswaController::class, 'storePelanggaran'])->name('daftar.store');
        Route::delete('daftar/{pelanggaranNilai}', [IndisiplinerSiswaController::class, 'destroyPelanggaran'])->name('daftar.destroy');
        Route::get('get-siswa-by-rombel/{rombel}', [IndisiplinerSiswaController::class, 'getSiswaByRombel'])->name('getSiswaByRombel');
        Route::get('rekapitulasi', [IndisiplinerSiswaController::class, 'rekapitulasiIndex'])->name('rekapitulasi.index');
    });

    // --- GRUP LAPORAN ---
    Route::prefix('laporan')->name('laporan.')->group(function() {
        Route::get('absensi', [LaporanAbsensiController::class, 'index'])->name('absensi.index');
        Route::get('absensi/export', [LaporanAbsensiController::class, 'export'])->name('absensi.export');
        Route::get('absensi/tanpa-pulang', [LaporanAbsensiController::class, 'laporanTanpaPulang'])->name('absensi.tanpa_pulang');
    });

});

require __DIR__.'/auth.php';
