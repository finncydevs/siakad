<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_absensi', function (Blueprint $table) {
            $table->id();
            $table->time('jam_masuk_sekolah')->default('07:00:00');
            $table->time('jam_pulang_sekolah')->default('15:00:00');
            $table->integer('batas_toleransi_terlambat')->default(15)->comment('Dalam menit');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_absensi');
    }
};
