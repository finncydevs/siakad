<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';
    protected $fillable = [
        'siswa_id', 'iuran_id', 'tagihan_id', 'tanggal_bayar', 'jumlah_bayar',
        'master_kas_id', 'acc_jurnal_id', 'petugas_id', 'keterangan'
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];

    /**
     * Relasi ke siswa yang melakukan pembayaran.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Relasi ke master iuran.
     */
    public function iuran(): BelongsTo
    {
        return $this->belongsTo(Iuran::class);
    }

    /**
     * Relasi ke tagihan (jika ini pembayaran bulanan).
     */
    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class);
    }

    // Asumsi: Model AccJurnal, MasterKas, dan Gtk sudah ada di Models folder
}
