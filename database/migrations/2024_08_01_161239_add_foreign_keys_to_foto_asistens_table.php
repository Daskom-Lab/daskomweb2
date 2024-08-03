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
        Schema::table('foto_asistens', function (Blueprint $table) {
            $table->foreign(['kode'])->references(['kode'])->on('asistens')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('foto_asistens', function (Blueprint $table) {
            $table->dropForeign('foto_asistens_kode_foreign');
        });
    }
};
