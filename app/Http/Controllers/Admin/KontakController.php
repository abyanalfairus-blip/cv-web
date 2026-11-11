<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kontak;

/** Panel admin — Saluran kontak (WhatsApp, email, GitHub, LinkedIn). */
class KontakController extends CrudController
{
    protected string $model = Kontak::class;

    protected string $judul = 'Kontak';

    protected string $route = 'kontak';

    protected function fields(): array
    {
        return [
            'label'  => ['label' => 'Label', 'type' => 'text', 'rules' => ['required', 'max:50'], 'lebar' => 'half', 'help' => 'Mis. WhatsApp'],
            'ikon'   => ['label' => 'Ikon (teks pendek)', 'type' => 'text', 'rules' => ['required', 'max:10'], 'lebar' => 'half', 'help' => 'Mis. WA, @, </>, in'],
            'teks'   => ['label' => 'Teks yang ditampilkan', 'type' => 'text', 'rules' => ['required', 'max:255']],
            'url'    => ['label' => 'URL / link', 'type' => 'text', 'rules' => ['required', 'max:255'], 'help' => 'https://..., mailto:..., atau https://wa.me/62...'],
            'urutan' => ['label' => 'Urutan', 'type' => 'number', 'rules' => ['required', 'integer', 'min:0'], 'lebar' => 'half'],
        ];
    }

    protected function kolom(): array
    {
        return ['#' => 'urutan', 'Label' => 'label', 'Teks' => 'teks'];
    }
}
