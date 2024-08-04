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
        Schema::create('history_jagas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hari', 191);
            $table->integer('shift');
            $table->boolean('pj')->default(false);
            $table->unsignedBigInteger('asisten_id')->index('history_jagas_asisten_id_foreign');
            $table->unsignedBigInteger('modul_id')->index('history_jagas_modul_id_foreign');
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
        Schema::dropIfExists('history_jagas');
    }
};
