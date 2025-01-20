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
        Schema::create('laporan_pjs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('allasisten_id', 191);
            $table->text('laporan');
            $table->string('hari', 191);
            $table->integer('shift');
            $table->unsignedBigInteger('praktikum_id')->index('laporan_pjs_praktikum_id_foreign');
            $table->unsignedBigInteger('pj_id')->index('laporan_pjs_pj_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pjs');
    }
};
