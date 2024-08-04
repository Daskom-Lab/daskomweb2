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
        Schema::table('jawaban_mandiris', function (Blueprint $table) {
            $table->foreign(['soal_id'])->references(['id'])->on('soal_mandiris')->onDelete('CASCADE');
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
        Schema::table('jawaban_mandiris', function (Blueprint $table) {
            $table->dropForeign('jawaban_mandiris_soal_id_foreign');
            $table->dropForeign('jawaban_mandiris_praktikan_id_foreign');
            $table->dropForeign('jawaban_mandiris_modul_id_foreign');
        });
    }
};
