<?php
// ...
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rombels', function (Blueprint $table) {
            $table->id(); // Sesuai screenshot

            // Semua kolom dari screenshot Anda
            $table->string('rombongan_belajar_id', 191)->nullable();
            $table->text('nama')->nullable();
            $table->string('tingkat_pendidikan_id', 191)->nullable();
            $table->text('semester_id_str')->nullable();
            $table->text('jenis_rombel')->nullable();
            
            // PENTING: Ini adalah string, BUKAN relasi
            $table->string('kurikulum_id', 191)->nullable(); 
            $table->text('kurikulum_id_str')->nullable();
            
            $table->text('id_ruang')->nullable();
            $table->text('id_ruang_str')->nullable();
            $table->text('moving_class')->nullable();

            // PENTING: Ini adalah string, BUKAN relasi
            $table->string('ptk_id', 191)->nullable(); 
            $table->text('ptk_id_str')->nullable();

            // PENTING: Ini adalah string, BUKAN relasi
            $table->string('jurusan_id', 191)->nullable(); 
            $table->text('jurusan_id_str')->nullable();

            $table->text('anggota_rombel')->nullable();
            $table->text('pembelajaran')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rombels');
    }
};