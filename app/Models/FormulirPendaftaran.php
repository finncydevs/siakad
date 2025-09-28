<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulirPendaftaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_id', 
        'jalur_id', 
        'nama_lengkap', 
        'nisn', 
        'npun',
        'jenis_kelamin', 
        'tempat_lahir', 
        'tgl_lahir', 
        'nama_ayah', 
        'nama_ibu',
        'alamat', 
        'desa', 
        'kecamatan', 
        'kabupaten', 
        'provinsi',
        'kode_pos', 
        'kontak', 
        'asal_sekolah', 
        'kelas',
        'jurusan', 
        'ukuran_pakaian', 
        'pembayaran'
    ];

    public function tahunPpdb()
    {
        return $this->belongsTo(TahunPelajaran::class, 'tahun_id');
    }

    public function jalurPendaftaran()
    {
        return $this->belongsTo(JalurPendaftaran::class, 'jalur_id');
    }

    public function syarat()
    {
        return $this->belongsToMany(SyaratPendaftaran::class, 'formulir_syarat', 'formulir_id', 'syarat_id')
                    ->withPivot('is_checked')
                    ->withTimestamps();
    }
}
