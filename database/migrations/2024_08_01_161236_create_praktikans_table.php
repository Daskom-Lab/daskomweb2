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
        Schema::create('praktikans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 50);
            $table->string('nim', 20)->unique();
            $table->string('password', 191);
            $table->string('api_token', 80)->nullable()->unique();
            $table->unsignedBigInteger('kelas_id')->index('praktikans_kelas_id_foreign');
            $table->text('alamat');
            $table->string('nomor_telepon', 191);
            $table->string('email', 191)->unique();
            $table->rememberToken();
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
        Schema::dropIfExists('praktikans');
    }
};
