<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Data profil pemilik portfolio — dipakai di Hero, section #about,
     * dan bagian kontak. Tabel ini didesain sebagai singleton
     * (idealnya cuma diisi 1 baris), tapi tetap tabel biasa
     * biar gampang di-manage lewat Eloquent/admin panel nanti.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('school');
            $table->string('major');
            $table->string('location');
            $table->string('phone');
            $table->string('email');
            $table->text('summary');             // paragraf "Tentang Saya"
            $table->string('cv_file_path')->nullable(); // path file CV untuk /download-cv
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
