<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rombel extends Model {
    public function wali()
{
    // 'ptk_id' adalah kolom di tabel 'rombels'
    // 'id' adalah kolom di tabel 'gtks'/'ptk'
    return $this->belongsTo(Gtk::class, 'ptk_id', 'id');
}
    public function jurusan() {
        return $this->belongsTo(Jurusan::class);
    }
    public function kurikulum() {
        return $this->belongsTo(Kurikulum::class);
    }
}
