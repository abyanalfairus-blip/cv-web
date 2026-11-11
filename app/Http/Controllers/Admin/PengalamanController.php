<?php

namespace App\Http\Controllers\Admin;

use App\Models\KategoriSkill;
use App\Models\Pengalaman;

/** Panel admin — Pengalaman kerja, organisasi, proyek, dan praktikum (tampil sebagai quest). */
class PengalamanController extends CrudController
{
    protected string $model = Pengalaman::class;

    protected string $judul = 'Pengalaman';

    protected string $route = 'pengalaman';

    protected function fields(): array
    {
        return [
            'jenis'       => ['label' => 'Jenis', 'type' => 'select', 'options' => Pengalaman::JENIS, 'rules' => ['required', 'in:' . implode(',', array_keys(Pengalaman::JENIS))], 'lebar' => 'half'],
            'label_quest' => ['label' => 'Label quest', 'type' => 'text', 'rules' => ['required', 'max:30'], 'lebar' => 'half', 'help' => 'Mis. MAIN QUEST, QUEST, GUILD QUEST'],
            'judul'       => ['label' => 'Judul', 'type' => 'text', 'rules' => ['required', 'max:255']],
            'singkatan'   => ['label' => 'Nama singkat', 'type' => 'text', 'rules' => ['nullable', 'max:40'], 'lebar' => 'half', 'help' => 'Tampil di skill tree, mis. KP'],
            'instansi'    => ['label' => 'Instansi / organisasi / mata kuliah', 'type' => 'text', 'rules' => ['nullable', 'max:255'], 'lebar' => 'half'],
            'periode'     => ['label' => 'Periode', 'type' => 'text', 'rules' => ['nullable', 'max:255'], 'lebar' => 'half', 'help' => 'Mis. 2025 – 2026'],
            'status'      => ['label' => 'Status', 'type' => 'select', 'options' => ['selesai' => 'Selesai (CLEARED)', 'berjalan' => 'Berjalan (ON GOING)'], 'rules' => ['required', 'in:selesai,berjalan'], 'lebar' => 'half'],
            'deskripsi'   => ['label' => 'Deskripsi', 'type' => 'textarea', 'rules' => ['nullable']],
            'poin'        => ['label' => 'Rincian (bullet)', 'type' => 'lines', 'kolom' => ['isi'], 'help' => 'Satu baris satu poin. Boleh dikosongkan.'],
            'url_kode'    => ['label' => 'Link kode (GitHub)', 'type' => 'url', 'rules' => ['nullable', 'url', 'max:255']],
            'skill'       => ['label' => 'Skill yang dipakai', 'type' => 'relasi', 'options' => fn () => KategoriSkill::with('skill')->orderBy('urutan')->get()->mapWithKeys(fn ($k) => [$k->nama => $k->skill->pluck('nama', 'id')->all()])->all()],
            'utama'       => ['label' => 'Jadikan quest utama (kartu lebar di atas)', 'type' => 'checkbox'],
            'urutan'      => ['label' => 'Urutan', 'type' => 'number', 'rules' => ['required', 'integer', 'min:0'], 'lebar' => 'half'],
        ];
    }

    protected function kolom(): array
    {
        return ['#' => 'urutan', 'Judul' => 'judul', 'Jenis' => 'jenis_label', 'Status' => 'status', 'Skill' => fn ($p) => $p->skill->count()];
    }

    protected function with(): array
    {
        return ['skill'];
    }
}
