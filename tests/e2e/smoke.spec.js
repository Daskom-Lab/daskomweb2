import { test, expect } from '@playwright/test';

/**
 * Smoke test browser untuk hasil upgrade dependency frontend:
 *   - @inertiajs/react 3  (halaman Inertia ter-render, props sampai)
 *   - Vite 7              (aset dari manifest ter-load tanpa error konsol)
 *   - <title data-inertia> (judul tab dikelola Inertia)
 *   - axios 1.21 + js-cookie 3.0.8 (window.axios tersedia di bootstrap)
 *
 * Server dijalankan terpisah: `php artisan serve --port=8123`
 * Override dengan E2E_BASE_URL bila memakai FrankenPHP/Caddy.
 */
const BASE_URL = process.env.E2E_BASE_URL ?? 'http://127.0.0.1:8123';

test.describe('Inertia 3 + Vite 7 smoke', () => {
    test('login page renders the Inertia app without console errors', async ({ page }) => {
        const errors = [];
        page.on('console', (msg) => {
            if (msg.type() === 'error') {
                errors.push(msg.text());
            }
        });
        page.on('pageerror', (err) => errors.push(err.message));

        const response = await page.goto(`${BASE_URL}/login`, {
            waitUntil: 'networkidle',
        });

        expect(response?.status()).toBe(200);

        // Inertia v3 menaruh page object di <script type="application/json">,
        // bukan lagi atribut data-page pada elemen #app (perubahan v3).
        const app = page.locator('#app');
        await expect(app).toBeVisible();

        const pageObjectJson = await page
            .locator('script[type="application/json"]')
            .first()
            .textContent();

        const pageObject = JSON.parse(pageObjectJson);
        expect(pageObject.component).toBeTruthy();
        expect(pageObject.props).toBeTruthy();
        expect(pageObject.url).toContain('/login');

        // Judul dikelola Inertia (callback title di createInertiaApp), bukan
        // teks statis blade. Cukup pastikan judul terisi dan berasal dari halaman.
        const title = await page.title();
        expect(title).not.toBe('');
        expect(title.toLowerCase()).toContain('login');

        expect(errors, `console errors: ${errors.join(' | ')}`).toEqual([]);
    });

    test('client bundle exposes axios and the Inertia app mounts', async ({ page }) => {
        await page.goto(`${BASE_URL}/login`, { waitUntil: 'networkidle' });

        await expect(page.locator('form').first()).toBeVisible({ timeout: 15000 });

        const hasAxios = await page.evaluate(() => typeof window.axios === 'function');

        expect(hasAxios, 'bootstrap.js harus mengekspos window.axios').toBe(true);
    });

    test('vite manifest assets are served', async ({ page }) => {
        const assetResponses = [];

        page.on('response', (res) => {
            const url = res.url();
            if (/\/build\/assets\/.+\.(js|css)$/.test(url)) {
                assetResponses.push({ status: res.status(), url });
            }
        });

        await page.goto(`${BASE_URL}/login`, { waitUntil: 'networkidle' });

        expect(assetResponses.length).toBeGreaterThan(0);

        const failed = assetResponses.filter((r) => r.status >= 400);

        expect(failed, `aset gagal dimuat: ${JSON.stringify(failed)}`).toEqual([]);
    });
});
