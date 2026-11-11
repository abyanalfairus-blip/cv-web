<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel `pengalaman_skill` — Pivot many-to-many: skill apa saja yang dipakai di tiap pengalaman.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengalaman_skill', function (Blueprint $table) {
            $table->foreignId('pengalaman_id')->constrained('pengalaman')->cascadeOnDelete();
            $table->foreignId('skill_id')->constrained('skill')->cascadeOnDelete();
            $table->primary(['pengalaman_id', 'skill_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengalaman_skill');
    }
};
