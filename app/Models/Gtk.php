<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

<<<<<<< HEAD
class Gtk extends Model // <-- UBAH DI SINI
{
    use HasFactory;

   

    protected $guarded = [];

    /**
     * Relasi ke modul penggajian.
     */
    public function penggajians()
    {
        return $this->hasMany(Penggajian::class);
    }

    /**
     * Relasi ke pembayaran (sebagai petugas yang mencatat).
     */
    public function pembayaransDicatat()
    {
        return $this->hasMany(Pembayaran::class, 'petugas_id');
    }

    // Relasi lama Anda bisa dipindahkan ke sini
    // public function semuaTugas()
    // {
    //     return $this->hasMany(TugasPegawai::class);
    // }
}
=======
class Gtk extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gtks';
}
>>>>>>> origin/modul/absensi
