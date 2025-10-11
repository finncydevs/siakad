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
        Schema::create('formulir_syarat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('formulir_id')->index('formulir_syarat_formulir_id_foreign');
            $table->unsignedBigInteger('syarat_id')->index('formulir_syarat_syarat_id_foreign');
            $table->boolean('is_checked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulir_syarat');
    }
};
