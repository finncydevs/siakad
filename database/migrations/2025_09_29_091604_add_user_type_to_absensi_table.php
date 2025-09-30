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
    Schema::table('absensi', function (Blueprint $table) {
        // UBAH 'user_id' MENJADI 'pengguna_id' DI SINI
        $table->string('user_type')->after('pengguna_id');
    });
}

// Anda juga bisa menambahkan fungsi down untuk bisa rollback
public function down(): void
{
    Schema::table('absensi', function (Blueprint $table) {
        $table->dropColumn('user_type');
    });
}
};
