<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('foto_asistens', function (Blueprint $table) {
            $table->foreign(['kode'])->references(['kode'])->on('asistens')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foto_asistens', function (Blueprint $table) {
            $table->dropForeign('foto_asistens_kode_foreign');
        });
    }
};
