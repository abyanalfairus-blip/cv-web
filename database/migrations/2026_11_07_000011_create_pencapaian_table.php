<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel `pencapaian` — Pencapaian (ditampilkan sebagai achievement).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pencapaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_id')->constrained('profil')->cascadeOnDelete();
            $table->string('ikon', 10);
            $table->string('judul');
            $table->text('keterangan');
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pencapaian');
    }
};
