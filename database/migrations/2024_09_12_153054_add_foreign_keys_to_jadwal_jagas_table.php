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
        Schema::table('jadwal_jagas', function (Blueprint $table) {
            $table->foreign(['asisten_id'])->references(['id'])->on('asistens')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['kelas_id'])->references(['id'])->on('kelas')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_jagas', function (Blueprint $table) {
            $table->dropForeign('jadwal_jagas_asisten_id_foreign');
            $table->dropForeign('jadwal_jagas_kelas_id_foreign');
        });
    }
};
