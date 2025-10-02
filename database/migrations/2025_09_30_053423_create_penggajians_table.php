<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penggajians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gtk_id')->constrained('gtks')->onDelete('cascade');
            $table->foreignId('tahun_pelajaran_id')->constrained('tahun_pelajarans')->onDelete('cascade');
            $table->string('periode_bulan', 10);
            $table->unsignedBigInteger('jumlah_gaji_bersih');
            $table->enum('status_pembayaran', ['Belum Dibayar', 'Dibayar'])->default('Belum Dibayar');
            $table->date('tanggal_dibayar')->nullable();

            $table->unsignedBigInteger('master_kas_id');
            $table->unsignedBigInteger('acc_jurnal_id')->nullable();

            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['gtk_id', 'periode_bulan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penggajians');
    }
};
