<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Contracts\View\View;

/**
 * Menampilkan halaman CV bertema game RPG.
 *
 * Semua konten dibaca dari database lewat model Profil beserta relasinya.
 * Controller hanya menghitung angka turunan (level, bar status, jumlah
 * quest per skill) dari data yang ada, tanpa teks yang ditulis langsung.
 */
class CvController extends Controller
{
    public function __invoke(): View
    {
        $profil = Profil::lengkap()->first();

        abort_if(! $profil, 503, 'Data CV belum ada. Jalankan: php artisan migrate --seed');

        $pendidikan = $profil->pendidikanAktif ?? $profil->pendidikan->first();

        // Bar status: XP dari progres studi + satu bar per kategori skill.
        // Panjang bar kategori = jumlah pengalaman yang memakai skill di kategori itu (maks. 5).
        $bar = collect();
        if ($pendidikan) {
            $bar->push([
                'label'  => 'XP',
                'persen' => $pendidikan->progres,
                'warna'  => 'xp',
                'nilai'  => $pendidikan->semester_saat_ini
                    ? "SMT {$pendidikan->semester_saat_ini}/{$pendidikan->total_semester}"
                    : ucfirst($pendidikan->status),
            ]);
        }
        foreach ($profil->kategoriSkill as $kategori) {
            $jumlah = $kategori->skill->flatMap->pengalaman->unique('id')->count();
            $bar->push([
                'label'  => $kategori->kode,
                'persen' => min(100, $jumlah * 20),
                'warna'  => $kategori->warna,
                'nilai'  => "{$jumlah} quest",
            ]);
        }

        // Angka ringkasan di panel STATUS.
        $ringkasan = [
            ['angka' => $profil->pengalaman->where('status', 'selesai')->count(),  'label' => 'quest selesai'],
            ['angka' => $profil->pengalaman->where('status', 'berjalan')->count(), 'label' => 'quest aktif'],
            ['angka' => $profil->pencapaian->count(),                              'label' => 'achievement'],
            ['angka' => $profil->sertifikat->count(),                              'label' => 'sertifikat'],
        ];

        // Tombol filter quest: hanya jenis yang punya data.
        $jenisQuest = $profil->pengalaman->countBy('jenis');

        // Menu HUD (navigasi halaman, bukan konten profil).
        $menu = [
            'status' => 'STATUS',
            'quest'  => 'QUEST',
            'skill'  => 'SKILL',
            'item'   => 'ITEM',
            'loot'   => 'LOOT',
            'guild'  => 'GUILD',
            'party'  => 'PARTY',
        ];

        return view('cv', compact('profil', 'pendidikan', 'bar', 'ringkasan', 'jenisQuest', 'menu'));
    }
}
