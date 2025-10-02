<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('iuran_id')->constrained('iurans')->onDelete('cascade');
            $table->foreignId('tahun_pelajaran_id')->constrained('tahun_pelajarans')->onDelete('cascade');
            $table->string('periode', 10)->nullable(); // Contoh: 2024-07
            $table->unsignedBigInteger('jumlah_tagihan');
            $table->unsignedBigInteger('sisa_tagihan');
            $table->enum('status', ['Belum Bayar', 'Cicilan', 'Lunas'])->default('Belum Bayar');
            $table->timestamps();

            $table->unique(['siswa_id', 'iuran_id', 'periode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
