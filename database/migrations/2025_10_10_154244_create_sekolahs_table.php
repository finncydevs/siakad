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
        Schema::create('sekolahs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sekolah_id', 191)->nullable()->index();
            $table->text('nama')->nullable();
            $table->text('nss')->nullable();
            $table->text('npsn')->nullable();
            $table->string('bentuk_pendidikan_id', 191)->nullable()->index();
            $table->text('bentuk_pendidikan_id_str')->nullable();
            $table->text('status_sekolah')->nullable();
            $table->text('status_sekolah_str')->nullable();
            $table->text('alamat_jalan')->nullable();
            $table->text('rt')->nullable();
            $table->text('rw')->nullable();
            $table->text('kode_wilayah')->nullable();
            $table->text('kode_pos')->nullable();
            $table->text('nomor_telepon')->nullable();
            $table->text('nomor_fax')->nullable();
            $table->text('email')->nullable();
            $table->text('website')->nullable();
            $table->text('is_sks')->nullable();
            $table->text('lintang')->nullable();
            $table->text('bujur')->nullable();
            $table->text('dusun')->nullable();
            $table->text('desa_kelurahan')->nullable();
            $table->text('kecamatan')->nullable();
            $table->text('kabupaten_kota')->nullable();
            $table->text('provinsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolahs');
    }
};
