<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('izin_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->date('tanggal_izin');
            $table->enum('tipe_izin', ['DATANG_TERLAMBAT', 'PULANG_AWAL', 'KELUAR_SEMENTARA']);
            
            $table->time('jam_izin_mulai')->nullable(); // Nullable karena 'Datang Terlambat' tidak butuh ini
            $table->time('jam_izin_selesai')->nullable(); // Nullable karena 'Pulang Awal' tidak butuh ini
            
            $table->text('alasan');
            $table->enum('status', ['DISETUJUI', 'DIGUNAKAN', 'KADALUARSA', 'SEDANG_KELUAR'])->default('DISETUJUI');
            
            $table->foreignId('dicatat_oleh')->constrained('users')->onDelete('restrict');

            // Kolom khusus untuk fitur Keluar-Masuk
            $table->string('token_sementara')->nullable()->unique();
            $table->timestamp('waktu_keluar')->nullable();
            $table->timestamp('waktu_kembali')->nullable();
            
            $table->timestamps();

            // Indeks untuk mempercepat pencarian
            $table->index(['siswa_id', 'tanggal_izin']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('izin_siswa');
    }
};
