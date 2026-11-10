<?php

namespace Tests\Unit;

use Tests\TestCase;

/**
 * PHP 8.5 menandai konstanta PDO::MYSQL_ATTR_* sebagai deprecated dan
 * memindahkannya ke Pdo\Mysql::ATTR_*. Referensi langsung yang dievaluasi
 * tanpa syarat memicu "Deprecated: Constant PDO::MYSQL_ATTR_SSL_CA is
 * deprecated" setiap kali konfigurasi database dimuat.
 *
 * Konfigurasi memakai Pdo\Mysql::ATTR_* bila kelasnya ada dan hanya jatuh
 * kembali ke konstanta lama pada PHP < 8.5, sehingga kode tetap jalan di
 * 8.3/8.4 tanpa memicu deprecation di 8.5.
 */
class DatabaseConfigDeprecationTest extends TestCase
{
    public function test_mysql_option_key_matches_the_php_version(): void
    {
        if (! extension_loaded('pdo_mysql')) {
            $this->markTestSkipped('pdo_mysql tidak tersedia.');
        }

        $options = config('database.connections.mysql.options');

        $this->assertIsArray($options);

        $expected = class_exists(\Pdo\Mysql::class)
            ? \Pdo\Mysql::ATTR_SSL_CA
            : constant('PDO::MYSQL_ATTR_SSL_CA');

        $this->assertSame(
            env('MYSQL_ATTR_SSL_CA'),
            $options[$expected] ?? null,
            'Kunci opsi harus memakai konstanta yang sesuai versi PHP.'
        );
    }

    public function test_mariadb_option_key_matches_the_php_version(): void
    {
        if (! extension_loaded('pdo_mysql')) {
            $this->markTestSkipped('pdo_mysql tidak tersedia.');
        }

        $options = config('database.connections.mariadb.options');

        $expected = class_exists(\Pdo\Mysql::class)
            ? \Pdo\Mysql::ATTR_SSL_CA
            : constant('PDO::MYSQL_ATTR_SSL_CA');

        $this->assertSame(env('MYSQL_ATTR_SSL_CA'), $options[$expected] ?? null);
    }

    public function test_loading_database_config_emits_no_deprecation(): void
    {
        $deprecations = [];

        set_error_handler(function (int $level, string $message) use (&$deprecations): bool {
            if ($level === E_DEPRECATED || $level === E_USER_DEPRECATED) {
                $deprecations[] = $message;

                return true;
            }

            return false;
        }, E_DEPRECATED | E_USER_DEPRECATED);

        try {
            $fresh = require config_path('database.php');
        } finally {
            restore_error_handler();
        }

        $this->assertIsArray($fresh);
        $this->assertSame([], $deprecations, implode('; ', $deprecations));
    }
}
