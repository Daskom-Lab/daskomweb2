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
        Schema::table('praktikans', function (Blueprint $table) {
            $table->foreign(['kelas_id'])->references(['id'])->on('kelas')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('praktikans', function (Blueprint $table) {
            $table->dropForeign('praktikans_kelas_id_foreign');
        });
    }
};
