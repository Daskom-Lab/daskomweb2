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
        Schema::create('soal_tas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('modul_id')->index('soal_tas_modul_id_foreign');
            $table->text('pengantar');
            $table->text('kodingan');
            $table->text('pertanyaan');
            $table->text('jawaban_benar');
            $table->text('jawaban_salah1');
            $table->text('jawaban_salah2');
            $table->text('jawaban_salah3');
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
        Schema::dropIfExists('soal_tas');
    }
};
