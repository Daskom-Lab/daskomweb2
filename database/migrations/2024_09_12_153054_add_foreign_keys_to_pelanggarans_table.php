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
        Schema::table('pelanggarans', function (Blueprint $table) {
            $table->foreign(['asisten_id'])->references(['id'])->on('asistens')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['pelanggaran_id'])->references(['id'])->on('kode_pelanggarans')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggarans', function (Blueprint $table) {
            $table->dropForeign('pelanggarans_asisten_id_foreign');
            $table->dropForeign('pelanggarans_pelanggaran_id_foreign');
        });
    }
};
