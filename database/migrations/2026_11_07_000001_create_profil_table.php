<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel `profil` — Data diri utama (satu baris untuk pemilik CV).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nama_judul_1');                 // baris 1 judul besar, mis. ABYAN
            $table->string('nama_judul_2')->nullable();     // baris 2 judul besar, mis. ALFAIRUS
            $table->string('pre_judul')->nullable();        // teks kecil di atas nama
            $table->string('subjudul');                     // mis. Web Developer Berbasis Framework
            $table->string('kelas_karakter');               // mis. Fullstack Builder · Laravel × Kotlin
            $table->text('ringkasan');                      // paragraf profil (**teks** = tebal)
            $table->string('email');
            $table->string('domisili')->nullable();
            $table->text('ajakan')->nullable();             // kalimat di bagian kontak
            $table->string('footer')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil');
    }
};
