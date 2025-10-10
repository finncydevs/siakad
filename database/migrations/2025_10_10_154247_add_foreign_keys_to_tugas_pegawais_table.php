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
        Schema::table('tugas_pegawais', function (Blueprint $table) {
            $table->foreign(['pegawai_id'])->references(['id'])->on('pegawais')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tugas_pegawais', function (Blueprint $table) {
            $table->dropForeign('tugas_pegawais_pegawai_id_foreign');
        });
    }
};
