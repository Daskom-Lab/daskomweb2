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
        Schema::table('temp_jawabantps', function (Blueprint $table) {
            $table->foreign(['soal_id'])->references(['id'])->on('soal_tps')->onDelete('CASCADE');
            $table->foreign(['praktikan_id'])->references(['id'])->on('praktikans')->onDelete('CASCADE');
            $table->foreign(['modul_id'])->references(['id'])->on('moduls')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temp_jawabantps', function (Blueprint $table) {
            $table->dropForeign('temp_jawabantps_soal_id_foreign');
            $table->dropForeign('temp_jawabantps_praktikan_id_foreign');
            $table->dropForeign('temp_jawabantps_modul_id_foreign');
        });
    }
};
