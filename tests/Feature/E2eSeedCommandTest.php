<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Helper data E2E tinggal di tests/ (bukan app/) agar tidak ikut ter-deploy,
 * tetapi perintah artisan-nya harus tetap dapat dipanggil oleh skrip E2E.
 */
class E2eSeedCommandTest extends TestCase
{
    public function test_e2e_seed_command_is_registered(): void
    {
        $this->assertArrayHasKey(
            'e2e:seed',
            \Illuminate\Support\Facades\Artisan::all(),
            'Perintah e2e:seed harus terdaftar di artisan.'
        );
    }

    public function test_seed_command_lives_under_tests_directory(): void
    {
        $reflection = new \ReflectionClass(\Tests\Support\SeedE2eData::class);

        $path = realpath($reflection->getFileName());

        $this->assertStringStartsWith(
            realpath(base_path('tests')),
            $path,
            'Helper E2E harus berada di dalam tests/.'
        );

        $this->assertFileDoesNotExist(
            app_path('Console/Commands/SeedE2eUser.php'),
            'Tidak boleh ada salinan di app/.'
        );
    }
}
