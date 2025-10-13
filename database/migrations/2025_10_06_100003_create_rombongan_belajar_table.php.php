<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
 * Run the migrations.
 */
public function up(): void {
    Schema::create('rombels', function (Blueprint $table) { // Kita tetap pakai nama 'rombels' untuk konvensi Laravel
        $table->id();
        $table->string('nama_rombel');
        $table->string('jenis_rombel')->default('Reguler');

        // Relasi ke tabel pendukung
        $table->foreignId('kurikulum_id')->nullable()->constrained('kurikulum');
        $table->foreignId('jurusan_id')->nullable()->constrained('jurusan');
        $table->foreignId('wali_id')->nullable()->constrained('ptk'); // Ini untuk Wali Kelas (id_ptk_wali)

        $table->string('tingkat');
        $table->string('ruang')->nullable();
        $table->boolean('is_moving_class')->default(false);
        $table->boolean('melayani_kebutuhan_khusus')->default(false);
        $table->year('tahun_ajaran');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rombels');
    }
};
