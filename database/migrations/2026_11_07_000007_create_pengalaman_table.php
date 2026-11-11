<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel `pengalaman` — Pengalaman kerja, organisasi, proyek, dan praktikum (ditampilkan sebagai quest).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengalaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_id')->constrained('profil')->cascadeOnDelete();
            $table->enum('jenis', ['kerja', 'organisasi', 'proyek', 'praktikum']);
            $table->string('label_quest', 30);              // MAIN QUEST, BOSS RAID, QUEST, ...
            $table->string('judul');
            $table->string('singkatan', 40)->nullable();    // nama pendek di skill tree, mis. KP
            $table->string('instansi')->nullable();         // tempat / mata kuliah / organisasi
            $table->string('periode')->nullable();          // mis. 2026 – sekarang
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['selesai', 'berjalan'])->default('selesai');
            $table->boolean('utama')->default(false);       // kartu lebar di atas
            $table->string('url_kode')->nullable();         // link GitHub
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengalaman');
    }
};
