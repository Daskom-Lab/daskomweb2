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
        Schema::create('jawaban_mandiris', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('praktikan_id')->index('jawaban_mandiris_praktikan_id_foreign');
            $table->unsignedBigInteger('soal_id')->index('jawaban_mandiris_soal_id_foreign');
            $table->unsignedBigInteger('modul_id')->index('jawaban_mandiris_modul_id_foreign');
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
        Schema::dropIfExists('jawaban_mandiris');
    }
};
