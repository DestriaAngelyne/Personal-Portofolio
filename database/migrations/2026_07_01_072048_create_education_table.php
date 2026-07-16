<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Riwayat pendidikan — dipakai di section #education (timeline vertikal).
     * Kolom 'order' menentukan urutan tampil (terbaru ke terlama).
     */
    public function up(): void
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->string('period');           // contoh: "2024 – Sekarang"
            $table->string('school');           // contoh: "SMK Negeri 2 Surabaya"
            $table->string('major')->nullable(); // contoh: "Rekayasa Perangkat Lunak", boleh kosong (SMP/SD)
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
