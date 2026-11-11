<?php

namespace App\Http\Controllers\Admin;

use App\Models\Peralatan;

/** Panel admin — Tools yang dipakai (tampil sebagai inventory). */
class PeralatanController extends CrudController
{
    protected string $model = Peralatan::class;

    protected string $judul = 'Tools';

    protected string $route = 'peralatan';

    protected function fields(): array
    {
        return [
            'nama'       => ['label' => 'Nama tool', 'type' => 'text', 'rules' => ['required', 'max:255'], 'lebar' => 'half'],
            'ikon'       => ['label' => 'Ikon (teks pendek)', 'type' => 'text', 'rules' => ['required', 'max:10'], 'lebar' => 'half'],
            'keterangan' => ['label' => 'Keterangan', 'type' => 'text', 'rules' => ['nullable', 'max:255']],
            'urutan'     => ['label' => 'Urutan', 'type' => 'number', 'rules' => ['required', 'integer', 'min:0'], 'lebar' => 'half'],
        ];
    }

    protected function kolom(): array
    {
        return ['#' => 'urutan', 'Ikon' => 'ikon', 'Nama' => 'nama', 'Keterangan' => 'keterangan'];
    }
}
