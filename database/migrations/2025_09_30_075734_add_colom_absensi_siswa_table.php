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
            $table->time('jam_masuk')->nullable()->after('tanggal');
            $table->time('jam_pulang')->nullable()->after('jam_masuk');
            $table->string('status_kehadiran')->nullable()->after('status')->comment('Tepat Waktu, Terlambat');
        });
    }

    public function down(): void
    {
        Schema::table('absensi_siswa', function (Blueprint $table) {
            $table->dropColumn(['jam_masuk', 'jam_pulang', 'status_kehadiran']);
        });
    }
};
