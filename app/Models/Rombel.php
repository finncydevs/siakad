<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rombel extends Model {
    public function wali() {
        return $this->belongsTo(Ptk::class, 'wali_id');
    }
    public function jurusan() {
        return $this->belongsTo(Jurusan::class);
    }
    public function kurikulum() {
        return $this->belongsTo(Kurikulum::class);
    }
}
