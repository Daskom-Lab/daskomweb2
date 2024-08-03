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
        Schema::create('laporan_praktikans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('pesan');
            $table->double('rating_asisten', 8, 2);
            $table->double('rating_praktikum', 8, 2);
            $table->unsignedBigInteger('praktikan_id')->index('laporan_praktikans_praktikan_id_foreign');
            $table->unsignedBigInteger('asisten_id')->index('laporan_praktikans_asisten_id_foreign');
            $table->unsignedBigInteger('modul_id')->index('laporan_praktikans_modul_id_foreign');
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
        Schema::dropIfExists('laporan_praktikans');
    }
};
