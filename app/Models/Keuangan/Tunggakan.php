<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tunggakan extends Model
{
    use HasFactory;

    protected $table = 'tunggakans';
    protected $fillable = [
        'siswa_id', 'iuran_id', 'tahun_pelajaran_id', 'total_tunggakan_awal',
        'sisa_tunggakan', 'status'
    ];

    /**
     * Relasi ke siswa yang memiliki tunggakan ini.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}
