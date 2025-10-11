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
        Schema::table('formulir_pendaftarans', function (Blueprint $table) {
            $table->foreign(['jalur_id'])->references(['id'])->on('jalur_pendaftarans')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tahun_id'])->references(['id'])->on('tahun_pelajarans')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formulir_pendaftarans', function (Blueprint $table) {
            $table->dropForeign('formulir_pendaftarans_jalur_id_foreign');
            $table->dropForeign('formulir_pendaftarans_tahun_id_foreign');
        });
    }
};
