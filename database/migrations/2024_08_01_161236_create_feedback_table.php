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
        Schema::create('feedback', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('asisten_id')->index('feedback_asisten_id_foreign');
            $table->unsignedBigInteger('praktikan_id')->index('feedback_praktikan_id_foreign');
            $table->text('pesan');
            $table->unsignedBigInteger('kelas_id')->index('feedback_kelas_id_foreign');
            $table->boolean('read')->nullable()->default(false);
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
        Schema::dropIfExists('feedback');
    }
};
