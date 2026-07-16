<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');         // Untuk nama proyek
            $table->text('description');     // Untuk deskripsi lengkap proyek
            $table->json('features');        // Untuk menyimpan daftar fitur (dalam format Array/JSON)
            $table->json('tags');            // Untuk menyimpan tag teknologi (dalam format Array/JSON)
            $table->string('image')->nullable(); // Path gambar/screenshot proyek di storage/app/public
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
