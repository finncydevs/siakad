<?php

use Illuminate\Support\Facades\Route;

// Controller Utama
use App\Http\Controllers\ProfilSekolahController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\TugasPegawaiController;
use App\Http\Controllers\Admin\Kesiswaan\SiswaController;
// Controller Settings
use App\Http\Controllers\Admin\Settings\ApiSettingsController;
use App\Http\Controllers\Admin\Settings\SekolahController;

// Controller Kepegawaian
use App\Http\Controllers\Admin\Kepegawaian\GtkController;

// Controller Akademik
use App\Http\Controllers\Admin\Akademik\SemesterController;
use App\Http\Controllers\Admin\Akademik\TapelController;
use App\Http\Controllers\Admin\Akademik\ProgramKeahlianController;
use App\Http\Controllers\Admin\Akademik\PaketKeahlianController;
use App\Http\Controllers\Admin\Akademik\JurusanController;

// Controller Kesiswaan
use App\Http\Controllers\Admin\Kesiswaan\ppdb\DaftarPesertaDidikBaruController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\DaftarCalonPesertaDidikController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\PemberianNisController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\FormulirPendaftaranController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\JalurController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\TingkatPendaftaranController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\LaporanPendaftaranController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\LaporanQuotaController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\PenempatanKelasController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\QuotaController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\SyaratController;
use App\Http\Controllers\Admin\Kesiswaan\ppdb\TahunPpdbController;


use App\Http\Controllers\Admin\Absensi\AbsensiSiswaController;
use App\Http\Controllers\Admin\Pengaturan\HariLiburController;
use App\Http\Controllers\Admin\Pengaturan\PengaturanAbsensiController;
use App\Http\Controllers\Admin\Laporan\LaporanAbsensiController;
// Controller Rombongan Belajar
use App\Http\Controllers\Admin\Rombel\RombelRegulerController;
use App\Http\Controllers\Admin\Rombel\RombelPraktikController;
use App\Http\Controllers\Admin\Rombel\RombelEkstrakurikulerController;
use App\Http\Controllers\Admin\Rombel\RombelMapelPilihanController;
use App\Http\Controllers\Admin\Rombel\RombelWaliController;

// Controller Pengaturan


/*
|--------------------------------------------------------------------------
| Rute Web Utama
|--------------------------------------------------------------------------
*/


Route::get('/', function () {
    // Arahkan ke dashboard admin saat membuka halaman utama
    return redirect()->route('admin.dashboard');
})->name('home');

/*
|--------------------------------------------------------------------------
| Grup Rute untuk Panel Admin
|--------------------------------------------------------------------------
| Semua rute di bawah ini akan memiliki prefix 'admin' dan nama 'admin.'
| Contoh: route('admin.dashboard'), url('/admin/dashboard')
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

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
        Route::resource('izin-siswa', \App\Http\Controllers\Admin\Absensi\IzinSiswaController::class);
    });

    // --- GRUP PENGATURAN ---
    Route::prefix('pengaturan')->name('pengaturan.')->group(function() {
        Route::get('absensi', [PengaturanAbsensiController::class, 'edit'])->name('absensi.edit');
        Route::put('absensi', [PengaturanAbsensiController::class, 'update'])->name('absensi.update');
        Route::resource('hari-libur', HariLiburController::class)->except(['show', 'edit', 'update']);
        Route::get('/profil_sekolah', [ProfilSekolahController::class, 'edit'])->name('profil_sekolah.edit');
        Route::put('/profil_sekolah', [ProfilSekolahController::class, 'update'])->name('profil_sekolah.update');
        Route::get('/sekolah', [SekolahController::class, 'index'])->name('sekolah.index');
        Route::get('/webservice', [ApiSettingsController::class, 'index'])->name('webservice.index');
        Route::prefix('webservice')->name('webservice.')->group(function () {
            Route::get('/', [ApiSettingsController::class, 'index'])->name('index');
        });
    });

    // --- GRUP KEPEGAWAIAN ---
    Route::prefix('kepegawaian')->name('kepegawaian.')->group(function() {
        Route::get('/gtk/export/excel', [GtkController::class, 'exportExcel'])->name('gtk.export.excel');
        Route::resource('gtk', GtkController::class);
        Route::resource('tugas-pegawai', TugasPegawaiController::class)->except(['create', 'edit', 'show']);
    });

    // --- GRUP AKADEMIK ---
    Route::prefix('akademik')->name('akademik.')->group(function () {
        Route::resource('tapel', TapelController::class)->only(['index', 'store', 'destroy']);
        Route::patch('tapel/{tapel}/toggle', [TapelController::class, 'toggleStatus'])->name('tapel.toggle');
        Route::resource('semester', SemesterController::class)->only(['index']);
        Route::patch('semester/{semester}/toggle', [SemesterController::class, 'toggle'])->name('semester.toggle');
        Route::resource('program-keahlian', ProgramKeahlianController::class)->only(['index']);
        Route::resource('paket-keahlian', PaketKeahlianController::class)->only(['index']);
        Route::resource('jurusan', JurusanController::class)->only(['index']);
        Route::controller(TapelController::class)->prefix('tapel')->name('tapel.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::delete('/{tapel}', 'destroy')->name('destroy');
            Route::patch('/{tapel}/toggle', 'toggleStatus')->name('toggle');
        });
        Route::controller(SemesterController::class)->prefix('semester')->name('semester.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::patch('/{semester}/toggle', 'toggle')->name('toggle');
        });
    });

    // --- GRUP KESISWAAN ---
    // Kesiswaan
    Route::prefix('kesiswaan')->name('kesiswaan.')->group(function() {
        Route::get('/siswa/{siswa}/cetak-kartu', [SiswaController::class, 'cetakKartu'])->name('siswa.cetak_kartu');
        Route::get('/cetak-kartu-massal', [SiswaController::class, 'showCetakMassalIndex'])->name('siswa.cetak_massal_index');
        Route::get('/cetak-kartu-massal/{rombel}', [SiswaController::class, 'cetakKartuMassal'])->name('siswa.cetak_massal_show');
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

            // Tingkat Pendaftaran
            Route::resource('tingkat-ppdb', TingkatPendaftaranController::class);
                Route::prefix('kesiswaan')->name('kesiswaan.')->group(function () {

            // Quota Pendaftaran
            Route::resource('quota-ppdb', QuotaController::class);

            // Syarat Pendaftaran
            Route::resource('syarat-ppdb', SyaratController::class);
            Route::post('/syarat-ppdb/{id}/toggle-active', [SyaratController::class, 'toggleActive'])->name('syarat-ppdb.toggleActive');

            // Formulir Pendaftaran
            Route::resource('formulir-ppdb', FormulirPendaftaranController::class);
            Route::get('/get-syarat/{jalurId}', [SyaratController::class, 'getByJalur'])->name('admin.kesiswaan.ppdb.get-syarat');
            Route::patch('update-status/{id}', [FormulirPendaftaranController::class, 'updateStatus'])->name('updateStatus');

            // Pemberian NIS
            Route::get('pemberian-nis/generate',
                [PemberianNisController::class, 'generate']
            )->name('pemberian-nis.generate');
            Route::resource('pemberian-nis', PemberianNisController::class);

            Route::get('daftar-calon/resi/{id}', [DaftarCalonPesertaDidikController::class, 'resi'])->name('daftar_calon.resi');

            // Data Peserta Didik
            Route::resource('daftar-calon-peserta-didik', DaftarCalonPesertaDidikController::class);
            Route::resource('daftar-peserta-didik-baru', DaftarPesertaDidikBaruController::class);

            // Penempatan Kelas
            Route::resource('penempatan-kelas', PenempatanKelasController::class);
            Route::post('penempatan-kelas/update-kelas',
                [PenempatanKelasController::class, 'updateKelas']
            )->name('penempatan-kelas.update-kelas');


            // Laporan
            Route::resource('laporan-pendaftaran', LaporanPendaftaranController::class);
            Route::resource('laporan-quota', LaporanQuotaController::class);


        });
    });

    // --- GRUP ROMBONGAN BELAJAR ---
    Route::prefix('rombel')->name('rombel.')->group(function () {
        // Reguler
        Route::get('/reguler/create', [RombelRegulerController::class, 'create'])->name('reguler.create');
        Route::get('/reguler', [RombelRegulerController::class, 'index'])->name('reguler.index');

        // Praktik (ROUTE BARU DITAMBAHKAN)
        Route::get('/praktik/create', [RombelPraktikController::class, 'create'])->name('praktik.create');
        Route::get('/praktik', [RombelPraktikController::class, 'index'])->name('praktik.index');

        // Ekstrakurikuler (ROUTE BARU DITAMBAHKAN)
        Route::get('/ekstrakurikuler/create', [RombelEkstrakurikulerController::class, 'create'])->name('ekstrakurikuler.create');
        Route::get('/ekstrakurikuler', [RombelEkstrakurikulerController::class, 'index'])->name('ekstrakurikuler.index');

        // Mapel Pilihan (ROUTE BARU DITAMBAHKAN)
        Route::get('/mapel-pilihan/create', [RombelMapelPilihanController::class, 'create'])->name('mapel-pilihan.create');
        Route::get('/mapel-pilihan', [RombelMapelPilihanController::class, 'index'])->name('mapel-pilihan.index');

        // Wali (ROUTE BARU DITAMBAHKAN)
        Route::get('/wali/create', [RombelWaliController::class, 'create'])->name('wali.create');
        Route::get('/wali', [RombelWaliController::class, 'index'])->name('wali.index');
    });
});

    });

