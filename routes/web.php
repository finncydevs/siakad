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

use App\Http\Controllers\Admin\Landing\PpdbController;


use App\Http\Controllers\Admin\Absensi\AbsensiSiswaController;
use App\Http\Controllers\Admin\Absensi\IzinSiswaController; // Added for clarity
use App\Http\Controllers\Admin\Pengaturan\HariLiburController;
use App\Http\Controllers\Admin\Pengaturan\PengaturanAbsensiController;
use App\Http\Controllers\Admin\Laporan\LaporanAbsensiController;
// Controller Rombongan Belajar
use App\Http\Controllers\Admin\Rombel\RombelRegulerController;
use App\Http\Controllers\Admin\Rombel\RombelPraktikController;
use App\Http\Controllers\Admin\Rombel\RombelEkstrakurikulerController;
use App\Http\Controllers\Admin\Rombel\RombelMapelPilihanController;
use App\Http\Controllers\Admin\Rombel\RombelWaliController;

/*
|--------------------------------------------------------------------------
| Rute Web Utama
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
Route::prefix('ppdb')->name('ppdb.')->group(function() {
    Route::get('/', [LandingPpdbController::class, 'beranda'])->name('beranda');
    Route::get('/kompetensi-keahlian', [LandingPpdbController::class, 'kompetensiKeahlian'])->name('kompetensiKeahlian');
    Route::get('/daftar-calon-siswa', [LandingPpdbController::class, 'daftarCalonSiswa'])->name('daftarCalonSiswa');
    Route::get('/formulir-pendaftaran', [LandingPpdbController::class, 'formulirPendaftaran'])->name('formulirPendaftaran');
    Route::get('/kontak', [LandingPpdbController::class, 'kontak'])->name('kontak');

    Route::prefix('admin')->name('admin.')->group(function () {

    });
});


Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // --- GRUP LAPORAN ---
    Route::prefix('laporan')->name('laporan.')->group(function() {
        Route::get('absensi', [LaporanAbsensiController::class, 'index'])->name('absensi.index');
        Route::get('absensi/dashboard', [LaporanAbsensiController::class, 'dashboard'])->name('absensi.dashboard');
        Route::get('absensi/export', [LaporanAbsensiController::class, 'export'])->name('absensi.export');
        Route::get('absensi/tanpa-pulang', [LaporanAbsensiController::class, 'laporanTanpaPulang'])->name('absensi.tanpa_pulang');
    });

    // --- GRUP ABSENSI ---
    Route::prefix('absensi')->name('absensi.')->group(function () {
        // Grup Absensi Siswa
        Route::prefix('siswa')->name('siswa.')->group(function() {
            Route::get('/todays-scans', [AbsensiSiswaController::class, 'getTodaysScans'])->name('get_todays_scans');
            Route::get('/', [AbsensiSiswaController::class, 'index'])->name('index');
            Route::get('/form', [AbsensiSiswaController::class, 'show'])->name('show_form');
            Route::post('/', [AbsensiSiswaController::class, 'store'])->name('store');
            Route::get('/scanner', [AbsensiSiswaController::class, 'showScanner'])->name('show_scanner');
            Route::post('/handle-scan', [AbsensiSiswaController::class, 'handleScan'])->name('handle_scan');
        });
        // Resource Izin Siswa
        Route::resource('izin-siswa', IzinSiswaController::class);
    });

    // --- GRUP PENGATURAN ---
    Route::prefix('pengaturan')->name('pengaturan.')->group(function() {
        // Pengaturan Absensi
        Route::get('absensi', [PengaturanAbsensiController::class, 'edit'])->name('absensi.edit');
        Route::put('absensi', [PengaturanAbsensiController::class, 'update'])->name('absensi.update');
        // Hari Libur
        Route::resource('hari-libur', HariLiburController::class)->except(['show', 'edit', 'update']);
        // Profil Sekolah
        Route::get('/profil_sekolah', [ProfilSekolahController::class, 'edit'])->name('profil_sekolah.edit');
        Route::put('/profil_sekolah', [ProfilSekolahController::class, 'update'])->name('profil_sekolah.update');
        // Data Sekolah
        Route::get('/sekolah', [SekolahController::class, 'index'])->name('sekolah.index');
        // Web Service / API Settings
        Route::prefix('webservice')->name('webservice.')->group(function () {
            Route::get('/', [ApiSettingsController::class, 'index'])->name('index');
        });
    });

    // --- GRUP KEPEGAWAIAN ---
    Route::prefix('kepegawaian')->name('kepegawaian.')->group(function() {
        // GTK
        Route::get('/gtk/export/excel', [GtkController::class, 'exportExcel'])->name('gtk.export.excel');
        Route::resource('gtk', GtkController::class);
        // Tugas Pegawai
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
        // Siswa
        Route::get('/siswa/{siswa}/cetak-kartu', [SiswaController::class, 'cetakKartu'])->name('siswa.cetak_kartu');
        Route::get('/cetak-kartu-massal', [SiswaController::class, 'showCetakMassalIndex'])->name('siswa.cetak_massal_index');
        Route::get('/cetak-kartu-massal/{rombel}', [SiswaController::class, 'cetakKartuMassal'])->name('siswa.cetak_massal_show');
        Route::resource('siswa', SiswaController::class);

        // PPDB (Penerimaan Peserta Didik Baru)
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
            Route::resource('daftar-peserta-didik-baru', DaftarPesertaDidikBaruController::class);
            Route::resource('penempatan-kelas', PenempatanKelasController::class);
            Route::resource('laporan-pendaftaran', LaporanPendaftaranController::class);
            Route::resource('laporan-quota', LaporanQuotaController::class);
        });
    });

    // --- GRUP ROMBONGAN BELAJAR ---
    Route::prefix('rombel')->name('rombel.')->group(function () {
        // Reguler
        Route::get('/reguler/create', [RombelRegulerController::class, 'create'])->name('reguler.create');
        Route::get('/reguler', [RombelRegulerController::class, 'index'])->name('reguler.index');
        // Praktik
        Route::get('/praktik/create', [RombelPraktikController::class, 'create'])->name('praktik.create');
        Route::get('/praktik', [RombelPraktikController::class, 'index'])->name('praktik.index');
        // Ekstrakurikuler
        Route::get('/ekstrakurikuler/create', [RombelEkstrakurikulerController::class, 'create'])->name('ekstrakurikuler.create');
        Route::get('/ekstrakurikuler', [RombelEkstrakurikulerController::class, 'index'])->name('ekstrakurikuler.index');
        // Mapel Pilihan
        Route::get('/mapel-pilihan/create', [RombelMapelPilihanController::class, 'create'])->name('mapel-pilihan.create');
        Route::get('/mapel-pilihan', [RombelMapelPilihanController::class, 'index'])->name('mapel-pilihan.index');
        // Wali
        Route::get('/wali/create', [RombelWaliController::class, 'create'])->name('wali.create');
        Route::get('/wali', [RombelWaliController::class, 'index'])->name('wali.index');
    });
});

require __DIR__.'/auth.php';
