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
        Schema::create('history_jagas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('laporan_pj_id')->index('history_jagas_laporan_pj_id_foreign');
            $table->unsignedBigInteger('asisten_id')->index('history_jagas_asisten_id_foreign');
            $table->unsignedBigInteger('modul_id')->index('history_jagas_modul_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_jagas');
    }
};
