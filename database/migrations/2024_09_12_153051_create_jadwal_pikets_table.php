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
        Schema::create('jadwal_pikets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('asisten_id')->index('jadwal_pikets_asisten_id_foreign');
            $table->unsignedBigInteger('kelas_id')->index('jadwal_pikets_kelas_id_foreign');
            $table->unsignedBigInteger('modul_id')->index('jadwal_pikets_modul_id_foreign');
            $table->text('pesan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_pikets');
    }
};
