<?php

namespace App\Http\Controllers\Admin;

use App\Models\KategoriSkill;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Builder;

/** Panel admin — Keahlian per kategori. Hubungkan ke pengalaman lewat menu Pengalaman. */
class SkillController extends CrudController
{
    protected string $model = Skill::class;

    protected string $judul = 'Skill';

    protected string $route = 'skill';

    protected bool $milikProfil = false;

    protected function fields(): array
    {
        return [
            'kategori_skill_id' => ['label' => 'Kategori', 'type' => 'select', 'options' => fn () => KategoriSkill::orderBy('urutan')->pluck('nama', 'id')->all(), 'rules' => ['required', 'exists:kategori_skill,id'], 'lebar' => 'half'],
            'nama'              => ['label' => 'Nama skill', 'type' => 'text', 'rules' => ['required', 'max:255'], 'lebar' => 'half'],
            'keterangan'        => ['label' => 'Keterangan', 'type' => 'text', 'rules' => ['nullable', 'max:255'], 'help' => 'Tampil di skill tree jika skill belum dipakai di pengalaman mana pun.'],
            'urutan'            => ['label' => 'Urutan', 'type' => 'number', 'rules' => ['required', 'integer', 'min:0'], 'lebar' => 'half'],
        ];
    }

    protected function kolom(): array
    {
        return ['Kategori' => 'kategori.nama', '#' => 'urutan', 'Skill' => 'nama', 'Dipakai di' => fn ($s) => $s->pengalaman->count() . ' pengalaman'];
    }

    protected function with(): array
    {
        return ['kategori', 'pengalaman'];
    }

    protected function query(): Builder
    {
        return Skill::query()
            ->join('kategori_skill', 'kategori_skill.id', '=', 'skill.kategori_skill_id')
            ->orderBy('kategori_skill.urutan')->orderBy('skill.urutan')
            ->select('skill.*');
    }
}
