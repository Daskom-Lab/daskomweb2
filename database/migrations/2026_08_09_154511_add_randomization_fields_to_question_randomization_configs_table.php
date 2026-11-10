<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migrasi ini dibuat ketika tabel `question_randomization_configs` belum
 * memiliki kolom acak. Tabel tersebut kini sudah dibuat lengkap oleh
 * 2026_08_09_150434, sehingga migrasi ini wajib idempoten: hanya menambah
 * kolom yang memang belum ada. Tanpa penjagaan ini, database yang dimigrasi
 * dari nol gagal dengan "Duplicate column name 'category'".
 */
return new class extends Migration {
    public function up(): void
    {
        $columns = [
            'category' => fn (Blueprint $table) => $table->string('category', 10)->after('modul_id'),
            'easy_count' => fn (Blueprint $table) => $table->unsignedSmallInteger('easy_count')->default(5)->after('category'),
            'medium_count' => fn (Blueprint $table) => $table->unsignedSmallInteger('medium_count')->default(4)->after('easy_count'),
            'hard_count' => fn (Blueprint $table) => $table->unsignedSmallInteger('hard_count')->default(1)->after('medium_count'),
            'enabled' => fn (Blueprint $table) => $table->boolean('enabled')->default(false)->after('hard_count'),
        ];

        $missing = array_filter(
            $columns,
            fn (string $column) => ! Schema::hasColumn('question_randomization_configs', $column),
            ARRAY_FILTER_USE_KEY
        );

        if ($missing !== []) {
            Schema::table('question_randomization_configs', function (Blueprint $table) use ($missing) {
                foreach ($missing as $definition) {
                    $definition($table);
                }
            });
        }

        if (! Schema::hasIndex('question_randomization_configs', ['modul_id', 'category'])) {
            Schema::table('question_randomization_configs', function (Blueprint $table) {
                $table->unique(['modul_id', 'category']);
            });
        }
    }

    public function down(): void
    {
        //
    }
};
