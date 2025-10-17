<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // 1. Tambahkan baris ini
use Carbon\Carbon; // <-- Tambahkan ini

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
        // Mengatur lokal default untuk Carbon (penanganan tanggal & waktu) ke Bahasa Indonesia
        Carbon::setLocale('id');
    }
}

