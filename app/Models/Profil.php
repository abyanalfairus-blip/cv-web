<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Pemilik CV. Semua data lain terhubung ke tabel ini.
 */
class Profil extends Model
{
    protected $table = 'profil';

    protected $fillable = [
        'nama',
        'nama_judul_1',
        'nama_judul_2',
        'pre_judul',
        'subjudul',
        'kelas_karakter',
        'ringkasan',
        'email',
        'domisili',
        'ajakan',
        'footer',
    ];

    /**
     * Memuat profil beserta semua relasi yang dipakai halaman web dan PDF
     * (eager loading, supaya tidak terjadi query berulang / N+1).
     */
    public function scopeLengkap(Builder $query): Builder
    {
        return $query->with([
            'kontak',
            'pendidikan.mataKuliah',
            'pendidikanAktif',
            'pengalaman.poin',
            'pengalaman.skill',
            'kategoriSkill.skill.pengalaman',
            'peralatan',
            'pencapaian',
            'sertifikat',
        ]);
    }

    /** Ringkasan dengan **teks** diubah menjadi <b>teks</b>, setelah di-escape (aman dari XSS). */
    public function getRingkasanHtmlAttribute(): string
    {
        return preg_replace('/\*\*(.+?)\*\*/', '<b>$1</b>', e($this->ringkasan));
    }

    public function kontak(): HasMany
    {
        return $this->hasMany(Kontak::class)->orderBy('urutan');
    }

    public function pendidikan(): HasMany
    {
        return $this->hasMany(Pendidikan::class)->orderBy('urutan');
    }

    public function pengalaman(): HasMany
    {
        return $this->hasMany(Pengalaman::class)->orderBy('urutan');
    }

    public function kategoriSkill(): HasMany
    {
        return $this->hasMany(KategoriSkill::class)->orderBy('urutan');
    }

    public function peralatan(): HasMany
    {
        return $this->hasMany(Peralatan::class)->orderBy('urutan');
    }

    public function pencapaian(): HasMany
    {
        return $this->hasMany(Pencapaian::class)->orderBy('urutan');
    }

    public function sertifikat(): HasMany
    {
        return $this->hasMany(Sertifikat::class)->orderBy('urutan');
    }

    /** Pendidikan yang sedang ditempuh (untuk level & bar XP). */
    public function pendidikanAktif(): HasOne
    {
        return $this->hasOne(Pendidikan::class)->where('status', 'berjalan')->orderBy('urutan');
    }
}
