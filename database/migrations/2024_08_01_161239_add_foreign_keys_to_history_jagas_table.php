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
        Schema::table('history_jagas', function (Blueprint $table) {
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
        Schema::table('history_jagas', function (Blueprint $table) {
            $table->dropForeign('history_jagas_modul_id_foreign');
            $table->dropForeign('history_jagas_asisten_id_foreign');
        });
    }
};
