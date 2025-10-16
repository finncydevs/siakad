<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pengguna extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Nama tabel yang terhubung.
     */
    protected $table = 'penggunas';

    /**
     * Atribut yang boleh diisi massal.
     */
    protected $fillable = [
        'pengguna_id',
        'sekolah_id',
        'username',
        'nama',
        'peran_id_str',
        'password',
        'alamat',
        'no_telepon',
        'no_hp',
        'ptk_id',
        'peserta_didik_id',
    ];

    /**
     * Atribut yang disembunyikan.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Atribut yang di-casting.
     */
    protected $casts = [
        'password' => 'hashed', // Otomatis hash password saat diisi
    ];
}