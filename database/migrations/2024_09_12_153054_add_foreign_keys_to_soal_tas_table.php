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
        Schema::table('soal_tas', function (Blueprint $table) {
            $table->foreign(['modul_id'])->references(['id'])->on('moduls')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soal_tas', function (Blueprint $table) {
            $table->dropForeign('soal_tas_modul_id_foreign');
        });
    }
};
