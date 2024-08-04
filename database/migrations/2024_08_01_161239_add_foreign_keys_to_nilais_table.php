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
        Schema::table('nilais', function (Blueprint $table) {
            $table->foreign(['modul_id'])->references(['id'])->on('moduls')->onDelete('CASCADE');
            $table->foreign(['kelas_id'])->references(['id'])->on('kelas')->onDelete('CASCADE');
            $table->foreign(['praktikan_id'])->references(['id'])->on('praktikans')->onDelete('CASCADE');
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
        Schema::table('nilais', function (Blueprint $table) {
            $table->dropForeign('nilais_modul_id_foreign');
            $table->dropForeign('nilais_kelas_id_foreign');
            $table->dropForeign('nilais_praktikan_id_foreign');
            $table->dropForeign('nilais_asisten_id_foreign');
        });
    }
};
