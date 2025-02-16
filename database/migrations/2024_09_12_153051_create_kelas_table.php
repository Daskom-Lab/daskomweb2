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
        Schema::create('kelas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kelas', 10);
            $table->string('hari', 191);
            $table->integer('shift');
            $table->integer('isEnglish')->default(0);
            $table->timestamps();
            $table->integer('totalGroup')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
