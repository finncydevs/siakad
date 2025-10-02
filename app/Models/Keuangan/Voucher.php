<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';
    protected $fillable = ['siswa_id', 'tahun_pelajaran_id', 'nilai_voucher', 'keterangan'];

    /**
     * Relasi ke siswa yang menerima voucher ini.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}
