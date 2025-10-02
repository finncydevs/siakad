<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penggajian extends Model
{
    use HasFactory;

    protected $table = 'penggajians';
    protected $fillable = [
        'gtk_id', 'tahun_pelajaran_id', 'periode_bulan', 'jumlah_gaji_bersih',
        'status_pembayaran', 'tanggal_dibayar', 'master_kas_id', 'acc_jurnal_id',
        'keterangan'
    ];

    /**
     */
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Gtk::class, 'gtk_id');
    }
}
