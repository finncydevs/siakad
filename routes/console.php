<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('absensi:alfa')
    ->weekdays() // Hanya berjalan di hari kerja (Senin - Jumat)
    ->dailyAt('17:00') // Jalankan setiap hari pada jam 5 sore
    ->timezone('Asia/Jakarta'); // Sangat disarankan untuk menentukan zona waktu