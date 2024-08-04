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
        Schema::create('keluhan_aslabs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('pesan');
            $table->timestamps();
            $table->unsignedBigInteger('asisten_id')->index('keluhan_aslabs_asisten_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keluhan_aslabs');
    }
};
