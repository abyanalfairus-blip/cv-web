<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel `sertifikat` — Sertifikat kursus, seminar, dan kegiatan (ditampilkan sebagai loot).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_id')->constrained('profil')->cascadeOnDelete();
            $table->string('judul');
            $table->string('penerbit');
            $table->string('peran')->nullable();            // Peserta, Panitia, ...
            $table->string('jenis', 30);                    // KURSUS, SEMINAR, KULIAH UMUM
            $table->enum('kelangkaan', ['epic', 'rare', 'common'])->default('common');
            $table->text('keterangan')->nullable();
            $table->date('tanggal');
            $table->string('nomor')->nullable();
            $table->string('file')->nullable();             // path di folder public/
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sertifikat');
    }
};
