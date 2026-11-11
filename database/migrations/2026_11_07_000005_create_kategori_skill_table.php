<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel `kategori_skill` — Cabang skill tree (WEB, MOBILE, ...).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_id')->constrained('profil')->cascadeOnDelete();
            $table->string('nama');                         // WEB, ALGORITMA & AI, ...
            $table->string('kode', 5);                      // label bar status: WEB, MOB, ALG, SYS
            $table->enum('warna', ['xp', 'hp', 'mp', 'gold'])->default('hp');
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_skill');
    }
};
