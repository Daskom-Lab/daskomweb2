<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelanggarans', function (Blueprint $table) {
            $table->foreign(['pelanggaran_id'])->references(['id'])->on('kode_pelanggarans')->onDelete('CASCADE');
            $table->foreign(['asisten_id'])->references(['id'])->on('asistens')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pelanggarans', function (Blueprint $table) {
            $table->dropForeign('pelanggarans_pelanggaran_id_foreign');
            $table->dropForeign('pelanggarans_asisten_id_foreign');
        });
    }
};
