<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sertifikat;

/** Panel admin — Sertifikat kursus, seminar, dan kegiatan (tampil sebagai loot). */
class SertifikatController extends CrudController
{
    protected string $model = Sertifikat::class;

    protected string $judul = 'Sertifikat';

    protected string $route = 'sertifikat';

    protected function fields(): array
    {
        return [
            'judul'      => ['label' => 'Judul', 'type' => 'text', 'rules' => ['required', 'max:255']],
            'penerbit'   => ['label' => 'Penerbit', 'type' => 'text', 'rules' => ['required', 'max:255'], 'lebar' => 'half'],
            'peran'      => ['label' => 'Peran', 'type' => 'text', 'rules' => ['nullable', 'max:255'], 'lebar' => 'half', 'help' => 'Mis. Peserta, Panitia'],
            'jenis'      => ['label' => 'Jenis', 'type' => 'text', 'rules' => ['required', 'max:30'], 'lebar' => 'half', 'help' => 'Mis. KURSUS, SEMINAR'],
            'kelangkaan' => ['label' => 'Kelangkaan kartu', 'type' => 'select', 'options' => ['epic' => 'Epic (ungu)', 'rare' => 'Rare (biru)', 'common' => 'Common (abu-abu)'], 'rules' => ['required', 'in:epic,rare,common'], 'lebar' => 'half'],
            'tanggal'    => ['label' => 'Tanggal', 'type' => 'date', 'rules' => ['required', 'date'], 'lebar' => 'half'],
            'nomor'      => ['label' => 'Nomor sertifikat', 'type' => 'text', 'rules' => ['nullable', 'max:255'], 'lebar' => 'half'],
            'keterangan' => ['label' => 'Keterangan', 'type' => 'textarea', 'rules' => ['nullable']],
            'file'       => ['label' => 'File PDF sertifikat', 'type' => 'file', 'folder' => 'sertifikat', 'help' => 'Maks. 5 MB. Kosongkan jika tidak ingin mengganti file.'],
            'urutan'     => ['label' => 'Urutan', 'type' => 'number', 'rules' => ['required', 'integer', 'min:0'], 'lebar' => 'half'],
        ];
    }

    protected function kolom(): array
    {
        return ['#' => 'urutan', 'Judul' => 'judul', 'Tanggal' => fn ($s) => $s->tanggal?->translatedFormat('j M Y'), 'File' => fn ($s) => $s->file ? 'Ada' : '-'];
    }
}
