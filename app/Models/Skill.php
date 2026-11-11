<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Satu keahlian. Terhubung many-to-many dengan pengalaman yang memakainya.
 */
class Skill extends Model
{
    protected $table = 'skill';

    protected $fillable = [
        'kategori_skill_id',
        'nama',
        'keterangan',
        'urutan',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriSkill::class, 'kategori_skill_id');
    }

    public function pengalaman(): BelongsToMany
    {
        return $this->belongsToMany(Pengalaman::class, 'pengalaman_skill')->orderBy('urutan');
    }
}
