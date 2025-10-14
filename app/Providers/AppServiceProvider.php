<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
<<<<<<< HEAD
use Illuminate\Pagination\Paginator; // 1. Tambahkan baris ini
=======
use Illuminate\Pagination\Paginator;
>>>>>>> origin/modul/akademik

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
<<<<<<< HEAD
        Paginator::useBootstrapFive(); // 2. Tambahkan baris ini
=======
       Paginator::useBootstrapFive(); 
>>>>>>> origin/modul/akademik
    }
}

