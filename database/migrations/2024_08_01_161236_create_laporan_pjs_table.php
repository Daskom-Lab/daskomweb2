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
        Schema::create('laporan_pjs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('allasisten_id', 191);
            $table->text('laporan');
            $table->string('hari', 191);
            $table->integer('shift');
            $table->unsignedBigInteger('modul_id')->index('laporan_pjs_modul_id_foreign');
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
        Schema::dropIfExists('laporan_pjs');
    }
};
