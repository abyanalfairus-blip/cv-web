<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Tool yang dipakai (inventory).
 */
class Peralatan extends Model
{
    protected $table = 'peralatan';

    protected $fillable = [
        'profil_id',
        'ikon',
        'nama',
        'keterangan',
        'urutan',
    ];

    public function profil(): BelongsTo
    {
        return $this->belongsTo(Profil::class);
    }
}
