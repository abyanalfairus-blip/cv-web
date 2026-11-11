<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Mata kuliah relevan dalam satu riwayat pendidikan.
 */
class MataKuliah extends Model
{
    protected $table = 'mata_kuliah';

    protected $fillable = [
        'pendidikan_id',
        'nama',
        'keterangan',
        'urutan',
    ];

    public function pendidikan(): BelongsTo
    {
        return $this->belongsTo(Pendidikan::class);
    }
}
