<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\CvController;
use App\Http\Controllers\CvPdfController;
use Illuminate\Support\Facades\Route;

/* ===================== HALAMAN PUBLIK ===================== */

// Halaman utama: CV bertema game
Route::get('/', CvController::class)->name('cv');

// Unduh CV versi PDF (format formal)
Route::get('/cv/download', CvPdfController::class)->name('cv.download');

/* ===================== PANEL ADMIN ===================== */

// Login (nama route "login" dipakai middleware auth untuk redirect)
Route::get('/admin/login', [Admin\AuthController::class, 'form'])->name('login');
Route::post('/admin/login', [Admin\AuthController::class, 'login'])
    ->middleware('throttle:5,1')                 // maks. 5 percobaan per menit
    ->name('admin.login');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::post('/logout', [Admin\AuthController::class, 'logout'])->name('logout');

    Route::get('/', Admin\DashboardController::class)->name('dashboard');

    // Profil: hanya satu baris, jadi cukup lihat & ubah
    Route::get('/profil', [Admin\ProfilController::class, 'editProfil'])->name('profil.index');
    Route::put('/profil/{id}', [Admin\ProfilController::class, 'update'])->name('profil.update');

    // CRUD per tabel: index, create, store, edit, update, destroy
    $crud = [
        'kontak'         => Admin\KontakController::class,
        'pendidikan'     => Admin\PendidikanController::class,
        'pengalaman'     => Admin\PengalamanController::class,
        'kategori-skill' => Admin\KategoriSkillController::class,
        'skill'          => Admin\SkillController::class,
        'peralatan'      => Admin\PeralatanController::class,
        'pencapaian'     => Admin\PencapaianController::class,
        'sertifikat'     => Admin\SertifikatController::class,
    ];
    foreach ($crud as $nama => $controller) {
        Route::resource($nama, $controller)
            ->except('show')
            ->parameters([$nama => 'id']);
    }
});
