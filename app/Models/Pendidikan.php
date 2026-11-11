<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Riwayat pendidikan.
 */
class Pendidikan extends Model
{
    protected $table = 'pendidikan';

    protected $fillable = [
        'profil_id',
        'institusi',
        'jenjang',
        'jurusan',
        'semester_saat_ini',
        'total_semester',
        'tahun_masuk',
        'tahun_lulus',
        'status',
        'urutan',
    ];

    public function profil(): BelongsTo
    {
        return $this->belongsTo(Profil::class);
    }

    public function mataKuliah(): HasMany
    {
        return $this->hasMany(MataKuliah::class)->orderBy('urutan');
    }

    /** Persentase studi yang sudah ditempuh, dipakai bar XP. */
    public function getProgresAttribute(): int
    {
        if (! $this->semester_saat_ini || ! $this->total_semester) {
            return $this->status === 'lulus' ? 100 : 0;
        }

        return (int) round($this->semester_saat_ini / $this->total_semester * 100);
    }
}
