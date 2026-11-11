<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Cabang skill tree.
 */
class KategoriSkill extends Model
{
    protected $table = 'kategori_skill';

    protected $fillable = [
        'profil_id',
        'nama',
        'kode',
        'warna',
        'urutan',
    ];

    public function profil(): BelongsTo
    {
        return $this->belongsTo(Profil::class);
    }

    public function skill(): HasMany
    {
        return $this->hasMany(Skill::class)->orderBy('urutan');
    }
}
