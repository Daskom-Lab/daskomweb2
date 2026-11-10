<?php

namespace Tests\Unit;

use App\Services\ImageKitService;
use ImageKit\ImageKit;
use Tests\TestCase;

/**
 * ImageKitService tidak boleh menyentuh konfigurasi ImageKit saat container
 * me-resolve service. Konfigurasi kosong hanya boleh gagal ketika client
 * benar-benar dipakai, sehingga artisan, queue worker, dan test suite dapat
 * boot tanpa kredensial ImageKit.
 */
class ImageKitServiceTest extends TestCase
{
    public function test_resolving_service_does_not_require_credentials(): void
    {
        config([
            'services.imagekit.public_key' => '',
            'services.imagekit.private_key' => '',
            'services.imagekit.endpoint_url' => '',
        ]);

        $service = app(ImageKitService::class);

        $this->assertInstanceOf(ImageKitService::class, $service);
    }

    public function test_get_client_builds_client_lazily_with_configured_credentials(): void
    {
        config([
            'services.imagekit.public_key' => 'public-key',
            'services.imagekit.private_key' => 'private-key',
            'services.imagekit.endpoint_url' => 'https://ik.imagekit.io/test',
        ]);

        $service = app(ImageKitService::class);

        $this->assertInstanceOf(ImageKit::class, $service->getClient());
    }

    public function test_get_client_throws_when_credentials_are_missing(): void
    {
        config([
            'services.imagekit.public_key' => '',
            'services.imagekit.private_key' => '',
            'services.imagekit.endpoint_url' => '',
        ]);

        $service = app(ImageKitService::class);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('ImageKit');

        $service->getClient();
    }
}
