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
        Schema::create('temp_jawabantps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('praktikan_id')->index('temp_jawabantps_praktikan_id_foreign');
            $table->unsignedBigInteger('soal_id')->index('temp_jawabantps_soal_id_foreign');
            $table->unsignedBigInteger('modul_id')->index('temp_jawabantps_modul_id_foreign');
            $table->text('jawaban');
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
        Schema::dropIfExists('temp_jawabantps');
    }
};
