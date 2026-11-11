<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Satu butir rincian pengalaman.
 */
class PengalamanPoin extends Model
{
    protected $table = 'pengalaman_poin';

    protected $fillable = [
        'pengalaman_id',
        'isi',
        'urutan',
    ];

    public function pengalaman(): BelongsTo
    {
        return $this->belongsTo(Pengalaman::class);
    }
}
