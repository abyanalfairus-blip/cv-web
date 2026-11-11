<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Membuat CV versi PDF (format formal, siap dikirim ke perusahaan).
 * Datanya sama dengan halaman web: diambil dari database lewat model Profil.
 *
 * GET /cv/download          -> file PDF langsung terunduh
 * GET /cv/download?lihat=1  -> PDF dibuka di tab browser (pratinjau)
 */
class CvPdfController extends Controller
{
    /** Judul bagian pengalaman di PDF, urut sesuai urutan tampil. */
    private const JUDUL_PENGALAMAN = [
        'kerja'      => 'Pengalaman Kerja',
        'organisasi' => 'Pengalaman Organisasi',
        'proyek'     => 'Proyek',
        'praktikum'  => 'Praktikum',
    ];

    public function __invoke(): Response
    {
        $profil = Profil::lengkap()->first();

        abort_if(! $profil, 503, 'Data CV belum ada. Jalankan: php artisan migrate --seed');

        // Kelompokkan pengalaman per jenis (kerja, organisasi, proyek, praktikum).
        $pengalaman = collect(self::JUDUL_PENGALAMAN)
            ->map(fn ($judul, $jenis) => [
                'judul' => $judul,
                'data'  => $profil->pengalaman->where('jenis', $jenis),
            ])
            ->filter(fn ($grup) => $grup['data']->isNotEmpty());

        $pdf = Pdf::loadView('pdf.cv', compact('profil', 'pengalaman'))
            ->setPaper('a4', 'portrait');

        $namaFile = 'CV-' . str_replace(' ', '-', Str::ascii($profil->nama)) . '.pdf';  // CV-Abyan-Alfairus.pdf

        return request()->boolean('lihat')
            ? $pdf->stream($namaFile)
            : $pdf->download($namaFile);
    }
}
