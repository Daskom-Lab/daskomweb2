<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('praktikums', function (Blueprint $table) {
            $table->foreign(['modul_id'])->references(['id'])->on('moduls')->onDelete('CASCADE');
            $table->foreign(['laporan_id'])->references(['id'])->on('laporan_pjs')->onDelete('CASCADE');
            $table->foreign(['pj_id'])->references(['id'])->on('asistens')->onDelete('CASCADE');
            $table->foreign(['kelas_id'])->references(['id'])->on('kelas')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('praktikums', function (Blueprint $table) {
            $table->dropForeign('praktikums_modul_id_foreign');
            $table->dropForeign('praktikums_laporan_id_foreign');
            $table->dropForeign('praktikums_pj_id_foreign');
            $table->dropForeign('praktikums_kelas_id_foreign');
        });
    }
};
