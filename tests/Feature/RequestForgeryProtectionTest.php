<?php

namespace Tests\Feature;

use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Http\Request;
use Tests\TestCase;

/**
 * Laravel 13 mengganti ValidateCsrfToken dengan PreventRequestForgery yang
 * juga memverifikasi header Sec-Fetch-Site.
 *
 * Catatan: PreventRequestForgery::runningUnitTests() membuat seluruh request
 * lolos ketika test suite berjalan, jadi perilaku end-to-end tidak dapat
 * diuji lewat $this->postJson(). Yang diuji di sini adalah kontrak middleware
 * (hasValidOrigin dan tokensMatch) serta konfigurasi middleware group yang
 * benar-benar terpasang.
 */
class RequestForgeryProtectionTest extends TestCase
{
    public function test_same_origin_requests_are_accepted_without_token(): void
    {
        $this->assertTrue($this->hasValidOrigin($this->requestWith(['Sec-Fetch-Site' => 'same-origin'])));
    }

    public function test_cross_site_requests_do_not_have_valid_origin(): void
    {
        $this->assertFalse($this->hasValidOrigin($this->requestWith(['Sec-Fetch-Site' => 'cross-site'])));
    }

    public function test_absent_browser_headers_do_not_bypass_token_check(): void
    {
        $request = $this->requestWith([]);

        $this->assertFalse($this->hasValidOrigin($request));
        $this->assertFalse($this->tokensMatch($request));
    }

    public function test_mismatched_token_does_not_match(): void
    {
        $request = $this->requestWith(['X-CSRF-TOKEN' => 'not-the-session-token']);

        $this->assertFalse($this->tokensMatch($request));
    }

    public function test_web_group_uses_prevent_request_forgery_once_without_deprecated_alias(): void
    {
        $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
        $reflection = new \ReflectionClass($kernel);
        $property = $reflection->getProperty('middlewareGroups');
        $property->setAccessible(true);

        $web = $property->getValue($kernel)['web'];

        $forgeryMiddleware = array_values(array_filter(
            $web,
            fn (string $middleware) => in_array($middleware, [
                PreventRequestForgery::class,
                \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
                \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            ], true)
        ));

        $this->assertSame([PreventRequestForgery::class], $forgeryMiddleware);
    }

    /**
     * @param  array<string, string>  $headers
     */
    private function requestWith(array $headers): Request
    {
        $request = Request::create('/__test/forgery', 'PUT', [], [], [], [], json_encode([]));

        // tokensMatch() membandingkan token request dengan token sesi, jadi
        // request harus membawa session store yang sudah dimulai.
        $session = app('session.store');
        $session->start();
        $request->setLaravelSession($session);

        foreach ($headers as $name => $value) {
            $request->headers->set($name, $value);
        }

        return $request;
    }

    private function hasValidOrigin(Request $request): bool
    {
        $middleware = app(PreventRequestForgery::class);

        $method = new \ReflectionMethod($middleware, 'hasValidOrigin');
        $method->setAccessible(true);

        return (bool) $method->invoke($middleware, $request);
    }

    private function tokensMatch(Request $request): bool
    {
        $middleware = app(PreventRequestForgery::class);

        $method = new \ReflectionMethod($middleware, 'tokensMatch');
        $method->setAccessible(true);

        return (bool) $method->invoke($middleware, $request);
    }
}
