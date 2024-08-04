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
        Schema::table('jadwal_pikets', function (Blueprint $table) {
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
        Schema::table('jadwal_pikets', function (Blueprint $table) {
            $table->dropForeign('jadwal_pikets_asisten_id_foreign');
        });
    }
};
