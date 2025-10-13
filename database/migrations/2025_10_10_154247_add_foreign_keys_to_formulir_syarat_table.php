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
        Schema::table('formulir_syarat', function (Blueprint $table) {
            $table->foreign(['formulir_id'])->references(['id'])->on('formulir_pendaftarans')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['syarat_id'])->references(['id'])->on('syarat_pendaftarans')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formulir_syarat', function (Blueprint $table) {
            $table->dropForeign('formulir_syarat_formulir_id_foreign');
            $table->dropForeign('formulir_syarat_syarat_id_foreign');
        });
    }
};
