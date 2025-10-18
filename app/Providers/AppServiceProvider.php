<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // 1. Tambahkan baris ini
use Illuminate\Support\Facades\View;
use App\Models\Sekolah;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive(); // 2. Tambahkan baris ini
        // Mengirim semua data siswa ke view tertentu
        
        View::share('profilSekolah', Sekolah::first());
    }
}

