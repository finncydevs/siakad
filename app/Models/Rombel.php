<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rombels';

    /**
     * Mendefinisikan relasi ke model Gtk (wali kelas).
     *
     * Catatan: Berdasarkan struktur database Anda, relasi ini menghubungkan
     * kolom `ptk_id_str` (yang berisi nama guru) di tabel `rombels`
     * dengan kolom `nama` di tabel `gtks`.
     */
    public function waliKelas()
    {
        // BENAR: Menggunakan foreign key 'ptk_id' untuk terhubung ke primary key Gtk.
        return $this->belongsTo(Gtk::class, 'ptk_id');
    }
}
