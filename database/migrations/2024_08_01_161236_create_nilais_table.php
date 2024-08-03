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
        Schema::create('nilais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('tp', 8, 2);
            $table->double('ta', 8, 2);
            $table->double('tk', 8, 2);
            $table->double('jurnal', 8, 2);
            $table->double('skill', 8, 2);
            $table->double('diskon', 8, 2);
            $table->double('rating', 8, 2);
            $table->text('review');
            $table->unsignedBigInteger('modul_id')->index('nilais_modul_id_foreign');
            $table->unsignedBigInteger('asisten_id')->index('nilais_asisten_id_foreign');
            $table->unsignedBigInteger('kelas_id')->index('nilais_kelas_id_foreign');
            $table->unsignedBigInteger('praktikan_id')->index('nilais_praktikan_id_foreign');
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
        Schema::dropIfExists('nilais');
    }
};
