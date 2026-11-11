<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pencapaian;

/** Panel admin — Pencapaian (tampil sebagai achievement). */
class PencapaianController extends CrudController
{
    protected string $model = Pencapaian::class;

    protected string $judul = 'Pencapaian';

    protected string $route = 'pencapaian';

    protected function fields(): array
    {
        return [
            'judul'      => ['label' => 'Judul', 'type' => 'text', 'rules' => ['required', 'max:255'], 'lebar' => 'half'],
            'ikon'       => ['label' => 'Ikon (1 karakter)', 'type' => 'text', 'rules' => ['required', 'max:10'], 'lebar' => 'half', 'help' => 'Mis. ★ ♥ ◇'],
            'keterangan' => ['label' => 'Keterangan', 'type' => 'textarea', 'rules' => ['required']],
            'urutan'     => ['label' => 'Urutan', 'type' => 'number', 'rules' => ['required', 'integer', 'min:0'], 'lebar' => 'half'],
        ];
    }

    protected function kolom(): array
    {
        return ['#' => 'urutan', 'Ikon' => 'ikon', 'Judul' => 'judul', 'Keterangan' => 'keterangan'];
    }
}
