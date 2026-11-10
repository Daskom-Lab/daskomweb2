<?php

namespace Tests\Unit;

use Tests\TestCase;

/**
 * bootstrap/providers.php harus hanya merujuk service provider yang benar-benar
 * dapat di-resolve. Rujukan ke kelas yang tidak ada membuat artisan, queue
 * worker, dan test suite gagal saat boot.
 */
class ServiceProviderRegistrationTest extends TestCase
{
    public function test_every_registered_provider_class_exists(): void
    {
        $providers = require base_path('bootstrap/providers.php');

        $missing = array_values(array_filter(
            $providers,
            fn (string $provider) => ! class_exists($provider)
        ));

        $this->assertSame([], $missing, 'Providers referenced but missing: '.implode(', ', $missing));
    }
}
