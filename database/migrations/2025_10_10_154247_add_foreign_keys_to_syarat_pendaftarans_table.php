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
        Schema::table('syarat_pendaftarans', function (Blueprint $table) {
            $table->foreign(['jalurPendaftaran_id'])->references(['id'])->on('jalur_pendaftarans')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tahunPelajaran_id'])->references(['id'])->on('tahun_pelajarans')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('syarat_pendaftarans', function (Blueprint $table) {
            $table->dropForeign('syarat_pendaftarans_jalurpendaftaran_id_foreign');
            $table->dropForeign('syarat_pendaftarans_tahunpelajaran_id_foreign');
        });
    }
};
