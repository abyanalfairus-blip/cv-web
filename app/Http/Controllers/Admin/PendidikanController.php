<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pendidikan;

/** Panel admin — Riwayat pendidikan beserta mata kuliah relevan. */
class PendidikanController extends CrudController
{
    protected string $model = Pendidikan::class;

    protected string $judul = 'Pendidikan';

    protected string $route = 'pendidikan';

    protected function fields(): array
    {
        return [
            'institusi'         => ['label' => 'Institusi', 'type' => 'text', 'rules' => ['required', 'max:255']],
            'jenjang'           => ['label' => 'Jenjang', 'type' => 'text', 'rules' => ['required', 'max:20'], 'lebar' => 'half', 'help' => 'Mis. S1, SMA, SMK'],
            'jurusan'           => ['label' => 'Jurusan', 'type' => 'text', 'rules' => ['required', 'max:255'], 'lebar' => 'half'],
            'status'            => ['label' => 'Status', 'type' => 'select', 'options' => ['berjalan' => 'Sedang berjalan', 'lulus' => 'Lulus'], 'rules' => ['required', 'in:berjalan,lulus'], 'lebar' => 'half'],
            'semester_saat_ini' => ['label' => 'Semester saat ini', 'type' => 'number', 'rules' => ['nullable', 'integer', 'min:1', 'max:14'], 'lebar' => 'half'],
            'total_semester'    => ['label' => 'Total semester', 'type' => 'number', 'rules' => ['nullable', 'integer', 'min:1', 'max:14'], 'lebar' => 'half'],
            'tahun_masuk'       => ['label' => 'Tahun masuk', 'type' => 'number', 'rules' => ['nullable', 'integer', 'min:1990', 'max:2100'], 'lebar' => 'half'],
            'tahun_lulus'       => ['label' => 'Tahun lulus', 'type' => 'number', 'rules' => ['nullable', 'integer', 'min:1990', 'max:2100'], 'lebar' => 'half'],
            'urutan'            => ['label' => 'Urutan', 'type' => 'number', 'rules' => ['required', 'integer', 'min:0'], 'lebar' => 'half'],
            'mataKuliah'        => ['label' => 'Mata kuliah relevan', 'type' => 'lines', 'kolom' => ['nama', 'keterangan'], 'help' => 'Satu baris satu mata kuliah. Format: Nama | keterangan'],
        ];
    }

    protected function kolom(): array
    {
        return ['#' => 'urutan', 'Institusi' => 'institusi', 'Jenjang' => fn ($p) => "{$p->jenjang} {$p->jurusan}", 'Status' => 'status', 'Mata kuliah' => fn ($p) => $p->mataKuliah->count()];
    }

    protected function with(): array
    {
        return ['mataKuliah'];
    }
}
