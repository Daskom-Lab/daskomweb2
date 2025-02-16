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
        Schema::create('soal_tps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('modul_id')->index('soal_tps_modul_id_foreign');
            $table->text('soal');
            $table->boolean('isEssay')->nullable()->default(false);
            $table->boolean('isProgram')->nullable()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_tps');
    }
};
