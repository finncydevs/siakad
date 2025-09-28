<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratPendaftaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahunPelajaran_id',
        'jalurPendaftaran_id',
        'syarat',
        'is_active'
    ];

    public function tahunPpdb()
    {
        return $this->belongsTo(TahunPelajaran::class, 'tahunPelajaran_id');
    }

    public function jalur()
    {
        return $this->belongsTo(JalurPendaftaran::class, 'jalur_id');
    }

}
