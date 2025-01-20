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
        Schema::table('laporan_pjs', function (Blueprint $table) {
            $table->foreign(['praktikum_id'])->references(['id'])->on('praktikums')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['pj_id'])->references(['id'])->on('asistens')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_pjs', function (Blueprint $table) {
            $table->dropForeign('laporan_pjs_praktikum_id_foreign');
            $table->dropForeign('laporan_pjs_pj_id_foreign');
        });
    }
};
