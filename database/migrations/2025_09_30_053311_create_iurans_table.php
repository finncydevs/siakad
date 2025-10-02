<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iurans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_iuran', 100);
            $table->enum('tipe_iuran', ['Bulanan', 'Bebas']); // Kunci fleksibilitas
            $table->unsignedBigInteger('besaran_default')->nullable();
            $table->foreignId('tahun_pelajaran_id')->constrained('tahun_pelajarans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iurans');
    }
};
