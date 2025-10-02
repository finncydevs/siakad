<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelanggaranNilai extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pelanggaran_nilai';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'ID';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'NIS',
        'IDtapel',
        'IDsemester',
        'IDkelas',
        'IDpelanggaran_poin',
        'tanggal',
        'jam',
        'poin',
        'IDmapel',
    ];

    /**
     * Mendapatkan detail poin dari catatan pelanggaran.
     */
    public function detailPoin()
    {
        return $this->belongsTo(PelanggaranPoin::class, 'IDpelanggaran_poin', 'ID');
    }

    /**
     * Mendapatkan data siswa yang terkait dengan pelanggaran.
     * Relasi ini menggunakan kolom 'NIS' di tabel ini dan 'nis' di tabel 'siswas'.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'NIS', 'nis');
    }
    
    /**
     * Mendapatkan data rombongan belajar (kelas) yang terkait dengan pelanggaran.
     */
    public function rombel()
    {
        // Relasi ini mengasumsikan 'IDkelas' di tabel ini
        // berelasi dengan 'id' di tabel 'rombels'.
        return $this->belongsTo(Rombel::class, 'IDkelas', 'id');
    }
}

