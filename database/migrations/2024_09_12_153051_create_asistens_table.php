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
        Schema::create('asistens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 50);
            $table->char('kode', 3)->unique();
            $table->string('password', 191);
            $table->string('api_token', 80)->nullable()->unique();
            $table->unsignedBigInteger('role_id')->index('asistens_role_id_foreign');
            $table->text('deskripsi');
            $table->string('nomor_telepon', 191);
            $table->string('id_line', 191);
            $table->string('instagram', 191);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistens');
    }
};
