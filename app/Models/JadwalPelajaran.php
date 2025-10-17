<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    use HasFactory;

    // Izinkan semua kolom untuk diisi secara massal
    protected $guarded = [];

    // Definisikan relasi ke model Rombel
    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }
}