<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Keahlian dasar / soft skills — dipakai di section #soft-skills (3 card).
     */
    public function up(): void
    {
        Schema::create('soft_skills', function (Blueprint $table) {
            $table->id();
            $table->string('title');       // contoh: "Communication"
            $table->text('description');   // contoh: "Mampu berkomunikasi dengan baik..."
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soft_skills');
    }
};
