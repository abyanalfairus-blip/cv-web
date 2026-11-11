<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Sertifikat kursus/seminar/kegiatan (loot).
 */
class Sertifikat extends Model
{
    protected $table = 'sertifikat';

    protected $fillable = [
        'profil_id',
        'judul',
        'penerbit',
        'peran',
        'jenis',
        'kelangkaan',
        'keterangan',
        'tanggal',
        'nomor',
        'file',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function profil(): BelongsTo
    {
        return $this->belongsTo(Profil::class);
    }

    /** True jika file PDF sertifikat benar-benar ada di folder public. */
    public function getAdaFileAttribute(): bool
    {
        return $this->file && file_exists(public_path($this->file));
    }
}
