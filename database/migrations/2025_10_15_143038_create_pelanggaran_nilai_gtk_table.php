<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pelanggaran_nilai_gtk', function (Blueprint $table) {
            $table->id('ID');
            $table->string('NIP'); // ambil dari tabel GTK, tapi tanpa FK langsung
            $table->unsignedBigInteger('IDpelanggaran_poin');
            $table->string('tapel')->nullable(); // contoh: 2025/2026
            $table->string('semester')->nullable(); // contoh: Ganjil / Genap
            $table->date('tanggal');
            $table->time('jam');
            $table->integer('poin')->default(0);

            $table->foreign('IDpelanggaran_poin')
                  ->references('ID')
                  ->on('pelanggaran_poin_gtk')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggaran_nilai_gtk');
    }
};
