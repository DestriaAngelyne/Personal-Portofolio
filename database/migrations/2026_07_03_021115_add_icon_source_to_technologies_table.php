<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom baru buat nandain icon ini asalnya dari CDN mana.
     * Default 'simpleicons' supaya semua data lama otomatis tetap
     * jalan tanpa perlu di-update manual satu-satu.
     *
     * Nilai yang dipakai di kode: 'simpleicons' | 'devicon'
     */
    public function up(): void
    {
        Schema::table('technologies', function (Blueprint $table) {
            $table->string('icon_source')->default('simpleicons')->after('icon_key');
        });
    }

    public function down(): void
    {
        Schema::table('technologies', function (Blueprint $table) {
            $table->dropColumn('icon_source');
        });
    }
};
