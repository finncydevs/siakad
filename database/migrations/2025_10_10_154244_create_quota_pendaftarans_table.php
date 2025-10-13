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
        Schema::create('quota_pendaftarans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tahunPelajaran_id')->index('quota_pendaftarans_tahunpelajaran_id_foreign');
            $table->string('keahlian')->nullable();
            $table->integer('jumlah_kelas')->nullable();
            $table->integer('quota')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quota_pendaftarans');
    }
};
