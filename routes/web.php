<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilSekolahController;

Route::get('/', function () {
    return view('welcome');
});

// Tambahkan rute ini
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});
Route::get('/profil-sekolah', [ProfilSekolahController::class, 'edit'])->name('profil-sekolah.edit');
Route::put('/profil-sekolah', [ProfilSekolahController::class, 'update'])->name('profil-sekolah.update');