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
        Schema::create('kumpul_tps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('modul_id')->index('kumpul_tps_modul_id_foreign');
            $table->unsignedBigInteger('kelas_id')->index('kumpul_tps_kelas_id_foreign');
            $table->unsignedBigInteger('praktikan_id')->index('kumpul_tps_praktikan_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kumpul_tps');
    }
};
