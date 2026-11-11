<?php

namespace App\Http\Controllers\Admin;

use App\Models\Profil;
use Illuminate\View\View;

/** Panel admin — Data diri utama (hanya satu baris, tidak bisa ditambah/dihapus). */
class ProfilController extends CrudController
{
    protected string $model = Profil::class;

    protected string $judul = 'Profil';

    protected string $route = 'profil';

    protected bool $milikProfil = false;

    protected function fields(): array
    {
        return [
            'nama'           => ['label' => 'Nama lengkap', 'type' => 'text', 'rules' => ['required', 'max:255']],
            'email'          => ['label' => 'Email', 'type' => 'email', 'rules' => ['required', 'email']],
            'nama_judul_1'   => ['label' => 'Judul besar baris 1', 'type' => 'text', 'rules' => ['required', 'max:255'], 'lebar' => 'half', 'help' => 'Mis. ABYAN'],
            'nama_judul_2'   => ['label' => 'Judul besar baris 2', 'type' => 'text', 'rules' => ['nullable', 'max:255'], 'lebar' => 'half', 'help' => 'Mis. ALFAIRUS'],
            'pre_judul'      => ['label' => 'Teks kecil di atas nama', 'type' => 'text', 'rules' => ['nullable', 'max:255']],
            'subjudul'       => ['label' => 'Subjudul / peran', 'type' => 'text', 'rules' => ['required', 'max:255'], 'help' => 'Bagian sebelum " — " juga dipakai sebagai peran di PDF.'],
            'kelas_karakter' => ['label' => 'Class karakter', 'type' => 'text', 'rules' => ['required', 'max:255']],
            'ringkasan'      => ['label' => 'Ringkasan profil', 'type' => 'textarea', 'rules' => ['required'], 'help' => 'Tulis **teks** untuk menebalkan.'],
            'domisili'       => ['label' => 'Domisili', 'type' => 'text', 'rules' => ['nullable', 'max:255']],
            'ajakan'         => ['label' => 'Kalimat ajakan di bagian kontak', 'type' => 'textarea', 'rules' => ['nullable']],
            'footer'         => ['label' => 'Footer', 'type' => 'text', 'rules' => ['nullable', 'max:255']],
        ];
    }

    protected function kolom(): array
    {
        return ['Nama' => 'nama', 'Email' => 'email'];
    }

    /** Profil hanya satu baris, jadi langsung membuka form ubah. */
    public function editProfil(): View
    {
        return $this->form(Profil::firstOrFail());
    }
}
