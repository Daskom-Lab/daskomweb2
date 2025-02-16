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
        Schema::table('feedback', function (Blueprint $table) {
            $table->foreign(['asisten_id'])->references(['id'])->on('asistens')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['kelas_id'])->references(['id'])->on('kelas')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['praktikan_id'])->references(['id'])->on('praktikans')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropForeign('feedback_asisten_id_foreign');
            $table->dropForeign('feedback_kelas_id_foreign');
            $table->dropForeign('feedback_praktikan_id_foreign');
        });
    }
};
