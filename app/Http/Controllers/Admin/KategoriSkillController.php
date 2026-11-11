<?php

namespace App\Http\Controllers\Admin;

use App\Models\KategoriSkill;

/** Panel admin — Cabang skill tree, juga menjadi bar status di halaman web. */
class KategoriSkillController extends CrudController
{
    protected string $model = KategoriSkill::class;

    protected string $judul = 'Kategori Skill';

    protected string $route = 'kategori-skill';

    protected function fields(): array
    {
        return [
            'nama'   => ['label' => 'Nama kategori', 'type' => 'text', 'rules' => ['required', 'max:255'], 'help' => 'Mis. WEB, MOBILE'],
            'kode'   => ['label' => 'Kode bar status', 'type' => 'text', 'rules' => ['required', 'max:5'], 'lebar' => 'half', 'help' => 'Maks. 5 huruf, mis. WEB'],
            'warna'  => ['label' => 'Warna bar', 'type' => 'select', 'options' => ['hp' => 'Merah', 'mp' => 'Biru', 'xp' => 'Hijau', 'gold' => 'Emas'], 'rules' => ['required', 'in:hp,mp,xp,gold'], 'lebar' => 'half'],
            'urutan' => ['label' => 'Urutan', 'type' => 'number', 'rules' => ['required', 'integer', 'min:0'], 'lebar' => 'half'],
        ];
    }

    protected function kolom(): array
    {
        return ['#' => 'urutan', 'Nama' => 'nama', 'Kode' => 'kode', 'Jumlah skill' => fn ($k) => $k->skill->count()];
    }

    protected function with(): array
    {
        return ['skill'];
    }
}
