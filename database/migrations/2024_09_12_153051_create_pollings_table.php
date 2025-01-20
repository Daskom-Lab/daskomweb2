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
        Schema::create('pollings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('polling_id')->index('pollings_polling_id_foreign');
            $table->unsignedBigInteger('asisten_id')->index('pollings_asisten_id_foreign');
            $table->unsignedBigInteger('praktikan_id')->index('pollings_praktikan_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pollings');
    }
};
