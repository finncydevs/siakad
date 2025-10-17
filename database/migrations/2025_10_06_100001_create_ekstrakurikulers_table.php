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
        Schema::create('ekstrakurikulers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ekskul');

            // PERBAIKAN: Ubah menjadi string agar sesuai Opsi 1 (Data Dump)
            // Ini akan membuat kolom varchar(191) dan MENGHAPUS foreign key
            $table->string('pembina_id', 191)->nullable();

            $table->string('prasarana')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekstrakurikulers');
    }
};