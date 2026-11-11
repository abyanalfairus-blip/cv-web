<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

/**
 * Setup database SEKALI PAKAI untuk hosting tanpa Terminal/SSH.
 *
 * Cara pakai:
 *   1. Isi SETUP_TOKEN di .env server dengan kode acak.
 *   2. Buka https://domain-anda/setup/{SETUP_TOKEN} di browser.
 *   3. Setelah berhasil, HAPUS baris SETUP_TOKEN dari .env
 *      (halaman ini otomatis mati / 404 jika token kosong).
 */
class SetupController extends Controller
{
    public function __invoke(string $token): Response
    {
        $rahasia = (string) config('app.setup_token');

        // Tanpa token di .env, atau token salah -> pura-pura halaman tidak ada.
        abort_if($rahasia === '' || ! hash_equals($rahasia, $token), 404);

        $log = [];

        // 1. Buat / perbarui semua tabel
        Artisan::call('migrate', ['--force' => true]);
        $log[] = '== MIGRATE ==';
        $log[] = trim(Artisan::output()) ?: 'Semua tabel sudah terbaru.';

        // 2. Isi data CV hanya jika tabel profil masih kosong (mencegah data dobel)
        if (Profil::query()->exists()) {
            $log[] = '';
            $log[] = '== SEED DILEWATI ==';
            $log[] = 'Data CV sudah ada, tidak diisi ulang.';
        } else {
            Artisan::call('db:seed', ['--force' => true]);
            $log[] = '';
            $log[] = '== SEED ==';
            $log[] = trim(Artisan::output());
        }

        // 3. Pastikan akun admin memakai ADMIN_EMAIL / ADMIN_PASSWORD dari .env
        Artisan::call('db:seed', ['--class' => 'AdminSeeder', '--force' => true]);
        $log[] = '';
        $log[] = '== AKUN ADMIN ==';
        $log[] = 'Akun admin diperbarui sesuai .env.';

        $log[] = '';
        $log[] = 'SELESAI. Sekarang HAPUS baris SETUP_TOKEN dari file .env di server.';

        return response(implode("\n", $log), 200, ['Content-Type' => 'text/plain; charset=utf-8']);
    }
}
