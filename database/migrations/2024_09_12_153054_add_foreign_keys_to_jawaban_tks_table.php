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
        Schema::table('jawaban_tks', function (Blueprint $table) {
            $table->foreign(['modul_id'])->references(['id'])->on('moduls')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['praktikan_id'])->references(['id'])->on('praktikans')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['soal_id'])->references(['id'])->on('soal_tks')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jawaban_tks', function (Blueprint $table) {
            $table->dropForeign('jawaban_tks_modul_id_foreign');
            $table->dropForeign('jawaban_tks_praktikan_id_foreign');
            $table->dropForeign('jawaban_tks_soal_id_foreign');
        });
    }
};
