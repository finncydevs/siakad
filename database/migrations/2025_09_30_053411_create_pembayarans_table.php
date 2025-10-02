<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('iuran_id')->constrained('iurans')->onDelete('cascade');
$table->foreignId('tagihan_id')->nullable()->constrained('tagihans')->onDelete('set null');
$table->foreignId('tunggakan_id')->nullable()->constrained('tunggakans')->onDelete('set null'); // <-- TAMBAHKAN INI
$table->date('tanggal_bayar');
            $table->unsignedBigInteger('jumlah_bayar');
            $table->unsignedBigInteger('master_kas_id');
            $table->unsignedBigInteger('acc_jurnal_id')->nullable();

            $table->foreignId('petugas_id')->nullable()->constrained('gtks')->onDelete('set null');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
