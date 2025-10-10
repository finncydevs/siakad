<?php

use Illuminate\Support\Facades\Route;

// Controller Settings
use App\Http\Controllers\Admin\Settings\ApiSettingsController;
use App\Http\Controllers\Admin\Settings\SekolahController;

// Controller Kepegawaian
use App\Http\Controllers\Admin\Kepegawaian\GtkController;
use App\Http\Controllers\Admin\Kesiswaan\Admin\Kepegawaian\TugasPegawaiController;

// Controller Akademik
use App\Http\Controllers\Admin\Akademik\SemesterController;
use App\Http\Controllers\Admin\Akademik\TapelController;
<<<<<<< HEAD
use App\Http\Controllers\Admin\Akademik\ProgramKeahlianController;
use App\Http\Controllers\Admin\Akademik\PaketKeahlianController;
use App\Http\Controllers\Admin\Akademik\JurusanController;
=======
use App\Http\Controllers\Admin\Akademik\JadwalPelajaranController;
>>>>>>> origin/modul/absensi

use App\Http\Controllers\Admin\Kesiswaan\DaftarCalonPesertaDidikController;
use App\Http\Controllers\Admin\Kesiswaan\FormulirPendaftaranController;
use App\Http\Controllers\Admin\Kesiswaan\JalurController;
use App\Http\Controllers\Admin\Kesiswaan\LaporanPendaftaranController;
use App\Http\Controllers\Admin\Kesiswaan\LaporanQuotaController;
use App\Http\Controllers\Admin\Kesiswaan\PenempatanKelasController;
use App\Http\Controllers\Admin\Kesiswaan\QuotaController;
use App\Http\Controllers\Admin\Kesiswaan\SiswaController;
use App\Http\Controllers\Admin\Kesiswaan\SyaratController;
use App\Http\Controllers\Admin\Kesiswaan\TahunPpdbController;

// Controller Rombongan Belajar
use App\Http\Controllers\Admin\Rombel\RombelRegulerController;
use App\Http\Controllers\Admin\Rombel\RombelPraktikController;
use App\Http\Controllers\Admin\Rombel\RombelEkstrakurikulerController;
use App\Http\Controllers\Admin\Rombel\RombelMapelPilihanController;
use App\Http\Controllers\Admin\Rombel\RombelWaliController;

<<<<<<< HEAD
use App\Http\Controllers\Admin\Keuangan\IuranController;
use App\Http\Controllers\Admin\Keuangan\KasController;
use App\Http\Controllers\Admin\Keuangan\PembayaranController;
use App\Http\Controllers\Admin\Keuangan\PengeluaranController;
use App\Http\Controllers\Admin\Keuangan\VoucherController;

// Controller Pengaturan
use App\Http\Controllers\Admin\Settings\ApiSettingsController;
=======
use App\Http\Controllers\Admin\Absensi\AbsensiSiswaController;
use App\Http\Controllers\Admin\Pengaturan\HariLiburController;
use App\Http\Controllers\Admin\Pengaturan\PengaturanAbsensiController;
use App\Http\Controllers\Admin\Laporan\LaporanAbsensiController;
>>>>>>> origin/modul/absensi

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
    Route::get('/absensi', [App\Http\Controllers\Guru\GuruAbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/kelas/{jadwal}', [App\Http\Controllers\Guru\GuruAbsensiController::class, 'show'])->name('absensi.show');
    Route::post('/absensi/kelas', [App\Http\Controllers\Guru\GuruAbsensiController::class, 'store'])->name('absensi.store');
});

/*
|--------------------------------------------------------------------------
| Grup Rute untuk Panel Admin
|--------------------------------------------------------------------------
| Semua rute di bawah ini akan memiliki prefix 'admin' dan nama 'admin.'
| Contoh: route('admin.dashboard'), url('/admin/dashboard')
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');

<<<<<<< HEAD
    // --- GRUP PENGATURAN ---
    Route::prefix('pengaturan')->name('pengaturan.')->group(function() {
        Route::get('/profil_sekolah', [ProfilSekolahController::class, 'edit'])->name('profil_sekolah.edit');
        Route::put('/profil_sekolah', [ProfilSekolahController::class, 'update'])->name('profil_sekolah.update');
=======
    Route::prefix('laporan')->name('laporan.')->group(function() {
    Route::get('absensi', [LaporanAbsensiController::class, 'index'])->name('absensi.index');
    Route::get('absensi/export', [LaporanAbsensiController::class, 'export'])->name('absensi.export');
        Route::get('absensi/tanpa-pulang', [LaporanAbsensiController::class, 'laporanTanpaPulang'])->name('absensi.tanpa_pulang');
});
     // --- GRUP ABSENSI ---
    Route::prefix('absensi')->name('absensi.')->group(function () {


        // --- Grup Absensi Siswa (BAGIAN YANG DIPERBAIKI) ---
        // Kita definisikan rute satu per satu untuk kejelasan
        Route::prefix('siswa')->name('siswa.')->group(function() {
            Route::get('/todays-scans', [AbsensiSiswaController::class, 'getTodaysScans'])->name('get_todays_scans');

            // Rute untuk menampilkan halaman PILIH KELAS
            // URL: /admin/absensi/siswa
            Route::get('/', [AbsensiSiswaController::class, 'index'])->name('index');

            // Rute untuk menampilkan FORM ABSENSI untuk kelas & tanggal tertentu
            // URL: /admin/absensi/siswa/form?rombel_id=...&tanggal=...
            Route::get('/form', [AbsensiSiswaController::class, 'show'])->name('show_form');

            // Rute untuk MENYIMPAN data absensi dari form
            // URL: /admin/absensi/siswa (Method: POST)
            Route::post('/', [AbsensiSiswaController::class, 'store'])->name('store');

            // Rute untuk scanner QR Code
            // URL: /admin/absensi/siswa/scanner
            Route::get('/scanner', [AbsensiSiswaController::class, 'showScanner'])->name('show_scanner');

            // Rute untuk menangani data dari scanner
            // URL: /admin/absensi/siswa/handle-scan (Method: POST)
            Route::post('/handle-scan', [AbsensiSiswaController::class, 'handleScan'])->name('handle_scan');
        });
        Route::resource('izin-siswa', \App\Http\Controllers\Admin\Absensi\IzinSiswaController::class);

    });


    Route::prefix('pengaturan')->name('pengaturan.')->group(function() {

        Route::get('absensi', [PengaturanAbsensiController::class, 'edit'])->name('absensi.edit');
        Route::put('absensi', [PengaturanAbsensiController::class, 'update'])->name('absensi.update');

        // Rute untuk Manajemen Hari Libur
        Route::resource('hari-libur', HariLiburController::class)->except(['show', 'edit', 'update']);
    });

    // --- GRUP PENGATURAN ---
    Route::prefix('pengaturan')->name('pengaturan.')->group(function() {
        Route::get('/profil_sekolah', [ProfilSekolahController::class, 'edit'])->name('profil_sekolah.edit');
        Route::put('/profil_sekolah', [ProfilSekolahController::class, 'update'])->name('profil_sekolah.update');

>>>>>>> origin/modul/absensi
        Route::prefix('webservice')->name('webservice.')->group(function () {
            Route::get('/', [ApiSettingsController::class, 'index'])->name('index');
        });
    });
<<<<<<< HEAD

    // --- GRUP KEPEGAWAIAN ---
=======

>>>>>>> origin/modul/absensi
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
<<<<<<< HEAD
        Route::resource('program-keahlian', ProgramKeahlianController::class)->only(['index']);
        Route::resource('paket-keahlian', PaketKeahlianController::class)->only(['index']);
        Route::resource('jurusan', JurusanController::class)->only(['index']);
    });

    // --- GRUP KESISWAAN ---
=======

        Route::get('jadwal', [JadwalPelajaranController::class, 'index'])->name('jadwal.index');
        Route::get('jadwal/{rombel}/edit', [JadwalPelajaranController::class, 'edit'])->name('jadwal.edit');
        Route::post('jadwal', [JadwalPelajaranController::class, 'store'])->name('jadwal.store');
        Route::delete('jadwal/{jadwal}', [JadwalPelajaranController::class, 'destroy'])->name('jadwal.destroy');
    });

>>>>>>> origin/modul/absensi
    Route::prefix('kesiswaan')->name('kesiswaan.')->group(function() {
        Route::get('/siswa/{siswa}/cetak-kartu', [SiswaController::class, 'cetakKartu'])->name('siswa.cetak_kartu');
        // Rute untuk menampilkan halaman pemilihan kelas
        Route::get('/cetak-kartu-massal', [SiswaController::class, 'showCetakMassalIndex'])->name('siswa.cetak_massal_index');
        // Rute untuk menampilkan halaman cetak untuk kelas yang dipilih
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
    Route::prefix('keuangan')->name('keuangan.')->group(function () {
 Route::get('/penerimaan', [PembayaranController::class, 'index'])->name('penerimaan.index');
 Route::post('/penerimaan', [PembayaranController::class, 'store'])->name('penerimaan.store');
 Route::get('/kas', [KasController::class, 'index'])->name('kas.index');
 Route::resource('/iuran', IuranController::class)->except(['create', 'edit', 'show']);
 Route::resource('/voucher', VoucherController::class)->only(['index', 'store', 'destroy']);
 Route::resource('/pengeluaran', PengeluaranController::class)->except(['create', 'edit', 'show']);
});
<<<<<<< HEAD
});

require __DIR__.'/auth.php';

require __DIR__.'/auth.php';
=======

require __DIR__.'/auth.php';
>>>>>>> origin/modul/absensi
