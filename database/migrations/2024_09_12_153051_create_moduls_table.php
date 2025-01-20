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
        Schema::create('moduls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('judul');
            $table->text('poin1');
            $table->text('poin2')->nullable();
            $table->text('poin3')->nullable();
            $table->timestamps();
            $table->boolean('isEnglish')->nullable()->default(false);
            $table->boolean('isUnlocked')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moduls');
    }
};
