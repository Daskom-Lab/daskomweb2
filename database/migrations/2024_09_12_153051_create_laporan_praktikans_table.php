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
        Schema::create('laporan_praktikans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('pesan');
            $table->unsignedBigInteger('praktikan_id')->index('laporan_praktikans_praktikan_id_foreign');
            $table->unsignedBigInteger('asisten_id')->index('laporan_praktikans_asisten_id_foreign');
            $table->unsignedBigInteger('modul_id')->index('laporan_praktikans_modul_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_praktikans');
    }
};
