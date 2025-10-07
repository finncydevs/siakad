<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Siswa extends Model
{
    use HasFactory;

    /**
     * PENYESUAIAN 2: Menggunakan $fillable untuk keamanan dan kejelasan.
     * Daftarkan semua kolom yang boleh diisi melalui form atau sinkronisasi.
     */
    protected $fillable = [
        'status',
        'foto',
    ];

    protected $casts = [
        'riwayat_penyakit' => 'array',

        'data_ayah' => 'array',
        'data_ibu' => 'array',
        'data_wali_laki' => 'array',
        'data_wali_perempuan' => 'array',
        'kepribadian' => 'array',
        'prestasi' => 'array',
        'tanggal_lahir' => 'date',
        'tanggal_masuk_sekolah' => 'date',
    ];

    /**
     * PENYESUAIAN 1: Menambahkan relasi belongsTo ke Rombel.
     * Ini sangat penting agar view tidak error saat memanggil $siswa->rombel.
     * Asumsi: foreign key di tabel siswas adalah 'rombongan_belajar_id'.
     */
    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombongan_belajar_id');
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return Storage::disk('public')->url($this->foto);
        }
      return  Storage::url('default_avatar.webp');

    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }


    // --- Relasi Modul Keuangan (Sudah Benar) ---
    public function tagihans() { return $this->hasMany(Tagihan::class); }
    public function tunggakans() { return $this->hasMany(Tunggakan::class); }
    public function pembayarans() { return $this->hasMany(Pembayaran::class); }
    public function vouchers() { return $this->hasMany(Voucher::class); }
}
