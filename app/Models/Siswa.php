<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Siswa extends Model
    {
        use HasFactory;

        protected $guarded = [];

        protected $casts = [
            'riwayat_penyakit' => 'array',
            'data_ayah' => 'array',
            'data_ibu' => 'array',
            'data_wali_laki' => 'array',
            'data_wali_perempuan' => 'array',
            'kepribadian' => 'array',
            'prestasi' => 'array',
        ];

        public function tagihans() { return $this->hasMany(Tagihan::class); }
public function tunggakans() { return $this->hasMany(Tunggakan::class); }
public function pembayarans() { return $this->hasMany(Pembayaran::class); }
public function vouchers() { return $this->hasMany(Voucher::class); }
    }
