<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\View\View;

/** Halaman awal panel admin: ringkasan jumlah data per tabel. */
class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $profil = Profil::withCount([
            'kontak', 'pendidikan', 'pengalaman', 'kategoriSkill', 'peralatan', 'pencapaian', 'sertifikat',
        ])->first();

        $kartu = [
            ['label' => 'Kontak',         'jumlah' => $profil?->kontak_count ?? 0,         'route' => 'admin.kontak.index'],
            ['label' => 'Pendidikan',     'jumlah' => $profil?->pendidikan_count ?? 0,     'route' => 'admin.pendidikan.index'],
            ['label' => 'Pengalaman',     'jumlah' => $profil?->pengalaman_count ?? 0,     'route' => 'admin.pengalaman.index'],
            ['label' => 'Kategori Skill', 'jumlah' => $profil?->kategori_skill_count ?? 0, 'route' => 'admin.kategori-skill.index'],
            ['label' => 'Skill',          'jumlah' => \App\Models\Skill::count(),          'route' => 'admin.skill.index'],
            ['label' => 'Tools',          'jumlah' => $profil?->peralatan_count ?? 0,      'route' => 'admin.peralatan.index'],
            ['label' => 'Pencapaian',     'jumlah' => $profil?->pencapaian_count ?? 0,     'route' => 'admin.pencapaian.index'],
            ['label' => 'Sertifikat',     'jumlah' => $profil?->sertifikat_count ?? 0,     'route' => 'admin.sertifikat.index'],
        ];

        return view('admin.dashboard', compact('profil', 'kartu'));
    }
}
