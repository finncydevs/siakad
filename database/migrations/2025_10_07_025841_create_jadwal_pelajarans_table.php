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
    Schema::create('jadwal_pelajarans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('rombel_id')->constrained('rombels')->onDelete('cascade');
        $table->string('hari'); // Contoh: Senin, Selasa, Rabu
        $table->integer('jam_ke'); // Jam pelajaran ke- (1, 2, 3, dst.)
        $table->string('pembelajaran_id'); // ID unik dari JSON pembelajaran
        $table->string('nama_mata_pelajaran');
        $table->string('nama_guru');
        $table->time('waktu_mulai');
        $table->time('waktu_selesai');
        $table->timestamps();

        // Mencegah entri duplikat untuk kelas, hari, dan jam yang sama
        $table->unique(['rombel_id', 'hari', 'jam_ke']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_pelajarans');
    }
};
