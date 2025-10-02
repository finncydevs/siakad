    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('izin_siswa', function (Blueprint $table) {
                $table->id();
                $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
                $table->date('tanggal_izin');
                $table->enum('tipe_izin', ['DATANG_TERLAMBAT', 'PULANG_AWAL', 'KELUAR_SEMENTARA']);
                $table->time('jam_izin_mulai')->nullable()->comment('Untuk Pulang Awal & Keluar Sementara');
                $table->time('jam_izin_selesai')->nullable()->comment('Untuk Datang Terlambat & Keluar Sementara');
                $table->text('alasan');
                $table->enum('status', ['DISETUJUI', 'DIGUNAKAN', 'KADALUARSA', 'SEDANG_KELUAR'])->default('DISETUJUI');
                $table->foreignId('dicatat_oleh')->constrained('users')->onDelete('restrict');
                $table->string('token_sementara')->nullable()->unique();
                $table->timestamp('waktu_keluar')->nullable();
                $table->timestamp('waktu_kembali')->nullable();
                $table->timestamps();
                $table->index(['siswa_id', 'tanggal_izin']);
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('izin_siswa');
        }
    };