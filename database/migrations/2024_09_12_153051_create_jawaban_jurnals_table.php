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
        Schema::create('jawaban_jurnals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('praktikan_id')->index('jawaban_jurnals_praktikan_id_foreign');
            $table->unsignedBigInteger('soal_id')->index('jawaban_jurnals_soal_id_foreign');
            $table->unsignedBigInteger('modul_id')->index('jawaban_jurnals_modul_id_foreign');
            $table->text('jawaban');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_jurnals');
    }
};
