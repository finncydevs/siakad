<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'siswas';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'registrasi_peserta_didik_id',
        'jenis_pendaftaran_id',
        'nipd',
        'tanggal_masuk_sekolah',
        'peserta_didik_id',
        'nama',
        'nisn',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'agama_id',
        'nomor_telepon_rumah',
        'nomor_telepon_selular',
        'nama_ayah',
        // Tambahkan kolom lain dari tabel siswa yang ingin Anda kelola
        'anggota_rombel_id',
        'nama_rombel',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk_sekolah' => 'date',
    ];

    /**
     * Mendapatkan data rombongan belajar (kelas) siswa.
     */
    public function rombel()
    {
        // Relasi ini mengasumsikan 'anggota_rombel_id' di tabel 'siswa'
        // berelasi dengan 'id' di tabel 'rombels'.
        return $this->belongsTo(Rombel::class, 'anggota_rombel_id', 'id');
    }

    /**
     * Mendapatkan semua riwayat pelanggaran yang dimiliki siswa ini.
     * Ini adalah relasi kebalikan dari yang ada di PelanggaranNilai.
     */
    public function pelanggaran()
    {
        return $this->hasMany(PelanggaranNilai::class, 'NIS', 'nis');
    }
}

