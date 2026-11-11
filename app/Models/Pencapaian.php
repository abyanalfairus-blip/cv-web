<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Pencapaian (achievement).
 */
class Pencapaian extends Model
{
    protected $table = 'pencapaian';

    protected $fillable = [
        'profil_id',
        'ikon',
        'judul',
        'keterangan',
        'urutan',
    ];

    public function profil(): BelongsTo
    {
        return $this->belongsTo(Profil::class);
    }
}
