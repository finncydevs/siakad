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
        // Kolom relasi yang benar
        'rombongan_belajar_id',
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
        // Relasi yang sudah diperbaiki sesuai struktur tabel
        return $this->belongsTo(Rombel::class, 'rombongan_belajar_id', 'rombongan_belajar_id');
    }

    /**
     * Mendapatkan semua riwayat pelanggaran yang dimiliki siswa ini.
     */
    public function pelanggaran()
    {
        // Relasi yang sudah diperbaiki (menggunakan 'nipd' sebagai kunci lokal)
        return $this->hasMany(PelanggaranNilai::class, 'NIS', 'nipd');
    }
}