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
        Schema::table('laporan_praktikans', function (Blueprint $table) {
            $table->foreign(['praktikan_id'])->references(['id'])->on('praktikans')->onDelete('CASCADE');
            $table->foreign(['modul_id'])->references(['id'])->on('moduls')->onDelete('CASCADE');
            $table->foreign(['asisten_id'])->references(['id'])->on('asistens')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laporan_praktikans', function (Blueprint $table) {
            $table->dropForeign('laporan_praktikans_praktikan_id_foreign');
            $table->dropForeign('laporan_praktikans_modul_id_foreign');
            $table->dropForeign('laporan_praktikans_asisten_id_foreign');
        });
    }
};
