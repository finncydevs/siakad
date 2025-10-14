<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('absensi_siswa', function (Blueprint $table) {
            // Mengubah kolom jadwal_id agar bisa bernilai NULL
            // Kita perlu `->change()` untuk memodifikasi kolom yang sudah ada
            $table->foreignId('jadwal_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensi_siswa', function (Blueprint $table) {
            // Kembalikan seperti semula jika migrasi di-rollback
            $table->foreignId('jadwal_id')->nullable(false)->change();
        });
    }
};
