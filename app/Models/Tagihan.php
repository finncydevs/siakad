<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class KasMutasi extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'kas_mutasis';

    /**
     * Mass assignment protection.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Tipe data native untuk atribut.
     *
     * @var array
     */
    protected $casts = [
        'tanggal' => 'date',
    ];
    public function masterKas(): BelongsTo
    {
        return $this->belongsTo(MasterKas::class);
    }

    public function sumber(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'sumber_transaksi', 'transaksi_id');
    }
}
