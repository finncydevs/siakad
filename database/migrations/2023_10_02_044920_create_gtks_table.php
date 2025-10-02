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
        // Hanya buat tabel JIKA tabel tersebut belum ada di database
        if (!Schema::hasTable('gtks')) {
            Schema::create('gtks', function (Blueprint $table) {
                $table->id();
                $table->string('ptk_id')->unique()->nullable()->comment('ID dari Dapodik');

                // Kolom dari screenshot Anda
                $table->string('tahun_ajaran_id')->nullable();
                $table->string('ptk_terdaftar_id')->nullable();
                $table->string('ptk_induk')->nullable();
                $table->date('tanggal_surat_tugas')->nullable();
                $table->string('nama');
                $table->string('jenis_kelamin')->nullable();
                $table->string('tempat_lahir')->nullable();
                $table->date('tanggal_lahir')->nullable();
                $table->string('agama_id')->nullable();
                $table->string('agama_id_str')->nullable();
                $table->string('nuptk')->nullable();
                $table->string('nik')->nullable();
                $table->string('jenis_ptk_id')->nullable();
                $table->string('jenis_ptk_id_str')->nullable();
                $table->string('jabatan_ptk_id')->nullable();
                $table->string('jabatan_ptk_id_str')->nullable();
                $table->string('status_kepegawaian_id')->nullable();
                $table->string('status_kepegawaian_id_str')->nullable();
                $table->string('nip')->nullable();
                $table->string('pendidikan_terakhir')->nullable();
                $table->string('bidang_studi_terakhir')->nullable();
                $table->string('pangkat_golongan_terakhir')->nullable();
                $table->text('rwy_pend_formal')->nullable();
                $table->text('rwy_kepangkatan')->nullable();

                $table->timestamps();
                $table->timestamp('last_sync_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gtks');
    }
};
