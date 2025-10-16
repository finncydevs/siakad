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
        Schema::create('penggunas', function (Blueprint $table) {
            $table->id();
            $table->string('pengguna_id', 191)->nullable();
            $table->string('sekolah_id', 191)->nullable();
            $table->text('username')->nullable();
            $table->text('nama')->nullable();
            $table->text('peran_id_str')->nullable();
            $table->text('password'); // Password harus diisi
            $table->text('alamat')->nullable();
            $table->text('no_telepon')->nullable();
            $table->text('no_hp')->nullable();
            $table->string('ptk_id', 191)->nullable();
            $table->string('peserta_didik_id', 191)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggunas');
    }
};