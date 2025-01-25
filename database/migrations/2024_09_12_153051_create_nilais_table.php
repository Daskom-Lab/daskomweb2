<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('tp');
            $table->double('ta');
            $table->double('d1');
            $table->double('d2');
            $table->double('d3');
            $table->double('d4');
            $table->double('l1');
            $table->double('l2');
            $table->double('avg');
            $table->unsignedBigInteger('modul_id')->index('nilais_modul_id_foreign');
            $table->unsignedBigInteger('asisten_id')->index('nilais_asisten_id_foreign');
            $table->unsignedBigInteger('kelas_id')->index('nilais_kelas_id_foreign');
            $table->unsignedBigInteger('praktikan_id')->index('nilais_praktikan_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
