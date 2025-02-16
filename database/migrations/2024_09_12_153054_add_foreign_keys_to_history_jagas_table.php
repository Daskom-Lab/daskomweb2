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
        Schema::table('history_jagas', function (Blueprint $table) {
            $table->foreign(['laporan_pj_id'])->references(['id'])->on('laporan_pjs')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['asisten_id'])->references(['id'])->on('asistens')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['modul_id'])->references(['id'])->on('moduls')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('history_jagas', function (Blueprint $table) {
            $table->dropForeign('history_jagas_laporan_pj_id_foreign');
            $table->dropForeign('history_jagas_asisten_id_foreign');
            $table->dropForeign('history_jagas_modul_id_foreign');
        });
    }
};
