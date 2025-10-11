<?php

use Illuminate\Support\Facades\Route;

// Controller Settings
use App\Http\Controllers\Admin\Settings\ApiSettingsController;
// use App\Http\Controllers\Admin\Settings\SekolahController; // Not used in the routes
use App\Http\Controllers\ProfilSekolahController;

// Controller Kepegawaian
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\TugasPegawaiController;
use App\Http\Controllers\Admin\Kepegawaian\GtkController;

// Controller Kesiswaan
use App\Http\Controllers\Admin\Kesiswaan\SiswaController;
use App\Http\Controllers\Admin\Kesiswaan\DaftarCalonPesertaDidikController;
use App\Http\Controllers\Admin\Kesiswaan\FormulirPendaftaranController;
use App\Http\Controllers\Admin\Kesiswaan\JalurController;
use App\Http\Controllers\Admin\Kesiswaan\LaporanPendaftaranController;
use App\Http\Controllers\Admin\Kesiswaan\LaporanQuotaController;
use App\Http\Controllers\Admin\Kesiswaan\PenempatanKelasController;
use App\Http\Controllers\Admin\Kesiswaan\QuotaController;
use App\Http\Controllers\Admin\Kesiswaan\SyaratController;
use App\Http\Controllers\Admin\Kesiswaan\TahunPpdbController;

// Controller Akademik
use App\Http\Controllers\Admin\Akademik\SemesterController;
use App\Http\Controllers\Admin\Akademik\TapelController;
use App\Http\Controllers\Admin\Akademik\ProgramKeahlianController;
use App\Http\Controllers\Admin\Akademik\PaketKeahlianController;
use App\Http\Controllers\Admin\Akademik\JurusanController;
use App\Http\Controllers\Admin\Akademik\JadwalPelajaranController; // Added missing use statement

// Controller Rombongan Belajar
use App\Http\Controllers\Admin\Rombel\RombelRegulerController;
use App\Http\Controllers\Admin\Rombel\RombelPraktikController;
use App\Http\Controllers\Admin\Rombel\RombelEkstrakurikulerController;
use App\Http\Controllers\Admin\Rombel\RombelMapelPilihanController;
use App\Http\Controllers\Admin\Rombel\RombelWaliController;

// Controller Keuangan
use App\Http\Controllers\Admin\Keuangan\IuranController;
use App\Http\Controllers\Admin\Keuangan\KasController;
use App\Http\Controllers\Admin\Keuangan\PembayaranController;
use App\Http\Controllers\Admin\Keuangan\PengeluaranController;
use App\Http\Controllers\Admin\Keuangan\VoucherController;

// Controller Absensi & Laporan
use App\Http\Controllers\Admin\Absensi\AbsensiSiswaController;
use App\Http\Controllers\Admin\Absensi\IzinSiswaController;
use App\Http\Controllers\Admin\Pengaturan\HariLiburController;
use App\Http\Controllers\Admin\Pengaturan\PengaturanAbsensiController;
use App\Http\Controllers\Admin\Laporan\LaporanAbsensiController;
use App\Http\Controllers\Guru\GuruAbsensiController;

/*
|--------------------------------------------------------------------------
| Rute Web Utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('admin.dashboard');
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
| Grup Rute untuk Panel Admin
|--------------------------------------------------------------------------
| Semua rute di bawah ini akan memiliki prefix 'admin' dan nama 'admin.'
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

    // --- GRUP LAPORAN ---
    Route::prefix('laporan')->name('laporan.')->group(function() {
        Route::get('absensi', [LaporanAbsensiController::class, 'index'])->name('absensi.index');
        Route::get('absensi/dashboard', [LaporanAbsensiController::class, 'dashboard'])->name('absensi.dashboard');
        Route::get('absensi/export', [LaporanAbsensiController::class, 'export'])->name('absensi.export');
        Route::get('absensi/tanpa-pulang', [LaporanAbsensiController::class, 'laporanTanpaPulang'])->name('absensi.tanpa_pulang');
    });

    // --- GRUP PENGATURAN (Gabungan dari duplikasi) ---
    Route::prefix('pengaturan')->name('pengaturan.')->group(function() {
        // Profil Sekolah
        Route::get('/profil_sekolah', [ProfilSekolahController::class, 'edit'])->name('profil_sekolah.edit');
        Route::put('/profil_sekolah', [ProfilSekolahController::class, 'update'])->name('profil_sekolah.update');

        // Webservice
        Route::prefix('webservice')->name('webservice.')->group(function () {
            Route::get('/', [ApiSettingsController::class, 'index'])->name('index');
        });

        // Pengaturan Absensi
        Route::get('absensi', [PengaturanAbsensiController::class, 'edit'])->name('absensi.edit');
        Route::put('absensi', [PengaturanAbsensiController::class, 'update'])->name('absensi.update');

        // Manajemen Hari Libur
        Route::resource('hari-libur', HariLiburController::class)->except(['show', 'edit', 'update']);
    });

    // --- GRUP KEPEGAWAIAN (Gabungan dari duplikasi) ---
    Route::prefix('kepegawaian')->name('kepegawaian.')->group(function() {
        // GTK (Guru dan Tenaga Kependidikan)
        Route::get('/gtk/export/excel', [GtkController::class, 'exportExcel'])->name('gtk.export.excel');
        Route::resource('gtk', GtkController::class);

        // Pegawai
        Route::resource('pegawai', PegawaiController::class); // Duplication handled

        // Tugas Pegawai
        Route::resource('tugas-pegawai', TugasPegawaiController::class)->except(['create', 'edit', 'show']); // Duplication handled
    });

    // --- GRUP AKADEMIK (Gabungan dari duplikasi) ---
    Route::prefix('akademik')->name('akademik.')->group(function () {
        // Tahun Pelajaran
        Route::resource('tapel', TapelController::class)->only(['index', 'store', 'destroy']);
        Route::patch('tapel/{tapel}/toggle', [TapelController::class, 'toggleStatus'])->name('tapel.toggle');

        // Semester
        Route::resource('semester', SemesterController::class)->only(['index']);
        Route::patch('semester/{semester}/toggle', [SemesterController::class, 'toggle'])->name('semester.toggle');

        // Program Keahlian, Paket Keahlian, Jurusan
        Route::resource('program-keahlian', ProgramKeahlianController::class)->only(['index']);
        Route::resource('paket-keahlian', PaketKeahlianController::class)->only(['index']);
        Route::resource('jurusan', JurusanController::class)->only(['index']);

        // Jadwal Pelajaran
        Route::get('jadwal', [JadwalPelajaranController::class, 'index'])->name('jadwal.index');
        Route::get('jadwal/{rombel}/edit', [JadwalPelajaranController::class, 'edit'])->name('jadwal.edit');
        Route::post('jadwal', [JadwalPelajaranController::class, 'store'])->name('jadwal.store');
        Route::delete('jadwal/{jadwal}', [JadwalPelajaranController::class, 'destroy'])->name('jadwal.destroy');
    });

    // --- GRUP KESISWAAN (Gabungan dari duplikasi) ---
    Route::prefix('kesiswaan')->name('kesiswaan.')->group(function() {
        // Siswa
        Route::get('/siswa/{siswa}/cetak-kartu', [SiswaController::class, 'cetakKartu'])->name('siswa.cetak_kartu');
        Route::get('/cetak-kartu-massal', [SiswaController::class, 'showCetakMassalIndex'])->name('siswa.cetak_massal_index');
        Route::get('/cetak-kartu-massal/{rombel}', [SiswaController::class, 'cetakKartuMassal'])->name('siswa.cetak_massal_show');
        Route::resource('siswa', SiswaController::class);

        // PPDB
        Route::prefix('ppdb')->name('ppdb.')->group(function () {
            // Tahun PPDB
            Route::resource('tahun-ppdb', TahunPpdbController::class);
            Route::post('/tahun-ppdb/{id}/toggle-active', [TahunPpdbController::class, 'toggleActive'])->name('tahun-ppdb.toggleActive');

            // Jalur PPDB
            Route::resource('jalur-ppdb', JalurController::class);
            Route::post('/jalur-ppdb/{id}/toggle-active', [JalurController::class, 'toggleActive'])->name('jalur-ppdb.toggleActive');

            // Quota, Syarat, Formulir, Calon Peserta Didik, Penempatan Kelas
            Route::resource('quota-ppdb', QuotaController::class);
            Route::resource('syarat-ppdb', SyaratController::class);
            Route::post('/syarat-ppdb/{id}/toggle-active', [SyaratController::class, 'toggleActive'])->name('syarat-ppdb.toggleActive');
            Route::resource('formulir-ppdb', FormulirPendaftaranController::class);
            Route::resource('daftar-calon-peserta-didik', DaftarCalonPesertaDidikController::class);
            Route::resource('penempatan-kelas', PenempatanKelasController::class);

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

    // --- GRUP KEUANGAN ---
    Route::prefix('keuangan')->name('keuangan.')->group(function () {
        // Pembayaran (Penerimaan)
        Route::get('/penerimaan', [PembayaranController::class, 'index'])->name('penerimaan.index');
        Route::post('/penerimaan', [PembayaranController::class, 'store'])->name('penerimaan.store');

        // Kas
        Route::get('/kas', [KasController::class, 'index'])->name('kas.index');

        // Iuran, Voucher, Pengeluaran
        Route::resource('/iuran', IuranController::class)->except(['create', 'edit', 'show']);
        Route::resource('/voucher', VoucherController::class)->only(['index', 'store', 'destroy']);
        Route::resource('/pengeluaran', PengeluaranController::class)->except(['create', 'edit', 'show']);
    });

    // --- GRUP ABSENSI ---
    Route::prefix('absensi')->name('absensi.')->group(function () {

        // Absensi Siswa
        Route::prefix('siswa')->name('siswa.')->group(function() {
            Route::get('/todays-scans', [AbsensiSiswaController::class, 'getTodaysScans'])->name('get_todays_scans');
            Route::get('/', [AbsensiSiswaController::class, 'index'])->name('index'); // Halaman PILIH KELAS
            Route::get('/form', [AbsensiSiswaController::class, 'show'])->name('show_form'); // FORM ABSENSI
            Route::post('/', [AbsensiSiswaController::class, 'store'])->name('store'); // SIMPAN data absensi
            Route::get('/scanner', [AbsensiSiswaController::class, 'showScanner'])->name('show_scanner'); // QR Code Scanner
            Route::post('/handle-scan', [AbsensiSiswaController::class, 'handleScan'])->name('handle_scan'); // Handle scan data
        });

        // Izin Siswa
        Route::resource('izin-siswa', IzinSiswaController::class);
    });
});

require __DIR__.'/auth.php';
