<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model {
    public function pembina()
{
    // 'pembina_id' adalah kolom di tabel 'ekstrakurikulers'
    // 'id' adalah kolom di tabel 'gtks'/'ptk'
    return $this->belongsTo(Gtk::class, 'pembina_id', 'id');
}
}
