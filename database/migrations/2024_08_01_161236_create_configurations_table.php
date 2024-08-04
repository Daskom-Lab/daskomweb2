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
        Schema::create('configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('registrationPraktikan_activation')->default(true);
            $table->boolean('registrationAsisten_activation')->default(true);
            $table->boolean('tp_activation')->default(false);
            $table->boolean('tubes_activation')->default(false);
            $table->boolean('secretfeature_activation')->default(false);
            $table->boolean('polling_activation')->default(false);
            $table->char('kode_asisten', 3)->default('Non');
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
        Schema::dropIfExists('configurations');
    }
};
