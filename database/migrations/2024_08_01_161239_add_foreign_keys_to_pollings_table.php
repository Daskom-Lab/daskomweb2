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
        Schema::table('pollings', function (Blueprint $table) {
            $table->foreign(['praktikan_id'])->references(['id'])->on('praktikans')->onDelete('CASCADE');
            $table->foreign(['polling_id'])->references(['id'])->on('jenis_pollings')->onDelete('CASCADE');
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
        Schema::table('pollings', function (Blueprint $table) {
            $table->dropForeign('pollings_praktikan_id_foreign');
            $table->dropForeign('pollings_polling_id_foreign');
            $table->dropForeign('pollings_asisten_id_foreign');
        });
    }
};
