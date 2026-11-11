<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel `pendidikan` — Riwayat pendidikan profil.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendidikan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_id')->constrained('profil')->cascadeOnDelete();
            $table->string('institusi');
            $table->string('jenjang', 20);                  // S1, SMA, SMK, ...
            $table->string('jurusan');
            $table->unsignedTinyInteger('semester_saat_ini')->nullable();
            $table->unsignedTinyInteger('total_semester')->nullable();
            $table->year('tahun_masuk')->nullable();
            $table->year('tahun_lulus')->nullable();
            $table->enum('status', ['berjalan', 'lulus'])->default('berjalan');
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendidikan');
    }
};
