<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        static::registerE2eHelpers();
    }

    /**
     * Mendaftarkan perintah artisan yang hanya dipakai pengujian.
     *
     * Helper E2E sengaja disimpan di tests/ agar tidak ikut ter-deploy, jadi
     * perintahnya harus didaftarkan manual. addCommands() men-deduplikasi
     * daftar, sehingga aman dipanggil dari setiap test.
     */
    protected static function registerE2eHelpers(): void
    {
        app(Kernel::class)->addCommands([
            \Tests\Support\SeedE2eData::class,
        ]);
    }
}
