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
        Schema::create('jalur_pendaftarans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tahunPelajaran_id')->index('jalur_pendaftarans_tahunpelajaran_id_foreign');
            $table->string('kode')->nullable();
            $table->string('jalur')->nullable();
            $table->string('keterangan')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jalur_pendaftarans');
    }
};
