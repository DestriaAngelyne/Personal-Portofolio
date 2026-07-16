<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tech stack — dipakai di section #skills (marquee 2 baris).
     * 'category' menentukan baris mana (frontend = row 1, backend = row 2).
     * 'icon_key' cocok dengan prop `icon` di komponen TechIcon.vue
     * (mis. 'vue', 'laravel', 'mysql', dst).
     */
    public function up(): void
    {
        Schema::create('technologies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon_key');
            $table->string('color', 7); // hex warna brand, contoh: #42b883
            $table->enum('category', ['frontend', 'backend'])->default('frontend');
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technologies');
    }
};
