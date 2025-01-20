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
        Schema::create('deadlines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('praktikums_id')->index('praktikums_praktikums_id_foreign');
            $table->dateTime('start_TA')->nullable();
            $table->dateTime('end_TA')->nullable();
            $table->dateTime('start_jurnal')->nullable();
            $table->dateTime('end_jurnal')->nullable();
            $table->dateTime('start_TM')->nullable();
            $table->dateTime('end_TM')->nullable();
            $table->dateTime('start_TK')->nullable();
            $table->dateTime('end_TK')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deadlines');
    }
};
