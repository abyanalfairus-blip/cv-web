<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Pengalaman kerja, organisasi, proyek, atau praktikum.
 */
class Pengalaman extends Model
{
    protected $table = 'pengalaman';

    protected $fillable = [
        'profil_id',
        'jenis',
        'label_quest',
        'judul',
        'singkatan',
        'instansi',
        'periode',
        'deskripsi',
        'status',
        'utama',
        'url_kode',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'utama' => 'boolean',
        ];
    }

    /** Label jenis untuk ditampilkan. */
    public const JENIS = [
        'kerja'      => 'Kerja',
        'organisasi' => 'Organisasi',
        'proyek'     => 'Proyek',
        'praktikum'  => 'Praktikum',
    ];

    public function profil(): BelongsTo
    {
        return $this->belongsTo(Profil::class);
    }

    public function poin(): HasMany
    {
        return $this->hasMany(PengalamanPoin::class)->orderBy('urutan');
    }

    public function skill(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'pengalaman_skill')->orderBy('urutan');
    }

    public function getJenisLabelAttribute(): string
    {
        return self::JENIS[$this->jenis] ?? ucfirst($this->jenis);
    }
}
