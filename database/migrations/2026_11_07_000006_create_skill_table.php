<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel `skill` — Keahlian, dikelompokkan per kategori.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_skill_id')->constrained('kategori_skill')->cascadeOnDelete();
            $table->string('nama');
            $table->string('keterangan')->nullable();       // dipakai bila skill belum terhubung ke pengalaman
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skill');
    }
};
