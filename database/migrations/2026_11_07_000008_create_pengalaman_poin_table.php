<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel `pengalaman_poin` — Butir rincian (bullet) sebuah pengalaman.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengalaman_poin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengalaman_id')->constrained('pengalaman')->cascadeOnDelete();
            $table->text('isi');
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengalaman_poin');
    }
};
