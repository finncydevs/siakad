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
        Schema::create('syarat_pendaftarans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tahunPelajaran_id')->index('syarat_pendaftarans_tahunpelajaran_id_foreign');
            $table->unsignedBigInteger('jalurPendaftaran_id')->index('syarat_pendaftarans_jalurpendaftaran_id_foreign');
            $table->text('syarat')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syarat_pendaftarans');
    }
};
