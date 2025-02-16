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
        Schema::table('kumpul_tps', function (Blueprint $table) {
            $table->foreign(['kelas_id'])->references(['id'])->on('kelas')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['modul_id'])->references(['id'])->on('moduls')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['praktikan_id'])->references(['id'])->on('praktikans')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kumpul_tps', function (Blueprint $table) {
            $table->dropForeign('kumpul_tps_kelas_id_foreign');
            $table->dropForeign('kumpul_tps_modul_id_foreign');
            $table->dropForeign('kumpul_tps_praktikan_id_foreign');
        });
    }
};
