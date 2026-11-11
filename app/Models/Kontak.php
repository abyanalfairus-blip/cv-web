<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Satu saluran kontak milik profil.
 */
class Kontak extends Model
{
    protected $table = 'kontak';

    protected $fillable = [
        'profil_id',
        'label',
        'ikon',
        'teks',
        'url',
        'urutan',
    ];

    public function profil(): BelongsTo
    {
        return $this->belongsTo(Profil::class);
    }

    /** Link eksternal dibuka di tab baru, mailto/tel tidak. */
    public function getEksternalAttribute(): bool
    {
        return str_starts_with($this->url, 'http');
    }
}
