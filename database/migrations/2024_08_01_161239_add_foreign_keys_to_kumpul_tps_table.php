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
        Schema::table('kumpul_tps', function (Blueprint $table) {
            $table->foreign(['praktikan_id'])->references(['id'])->on('praktikans')->onDelete('CASCADE');
            $table->foreign(['modul_id'])->references(['id'])->on('moduls')->onDelete('CASCADE');
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
        Schema::table('kumpul_tps', function (Blueprint $table) {
            $table->dropForeign('kumpul_tps_praktikan_id_foreign');
            $table->dropForeign('kumpul_tps_modul_id_foreign');
            $table->dropForeign('kumpul_tps_kelas_id_foreign');
        });
    }
};
