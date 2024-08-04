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
        Schema::create('praktikums', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('modul_id')->index('praktikums_modul_id_foreign');
            $table->unsignedBigInteger('kelas_id')->index('praktikums_kelas_id_foreign');
            $table->unsignedBigInteger('pj_id')->index('praktikums_pj_id_foreign');
            $table->unsignedBigInteger('laporan_id')->index('praktikums_laporan_id_foreign');
            $table->boolean('isActive')->default(false);
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('praktikums');
    }
};
