<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel `kontak` — Saluran kontak milik profil (WhatsApp, email, GitHub, LinkedIn).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kontak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_id')->constrained('profil')->cascadeOnDelete();
            $table->string('label');                        // WhatsApp, Email, ...
            $table->string('ikon', 10);                     // teks ikon pixel: WA, @, </>, in
            $table->string('teks');                         // yang ditampilkan
            $table->string('url');
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontak');
    }
};
