import { test, expect } from '@playwright/test';

/**
 * Root element Inertia harus di-hydrate hanya ketika server benar-benar
 * mengirim markup hasil SSR. Dengan `<div id="app"></div>` yang kosong,
 * `hydrateRoot()` memicu React error #418 (hydration mismatch) di console.
 *
 * Test ini adalah regresi untuk app.jsx: elemen kosong harus memakai
 * createRoot, bukan hydrateRoot.
 */
test('app entry mounts client-side when the root element is empty', async ({ page }) => {
    const errors = [];
    page.on('pageerror', (err) => errors.push(err.message));

    await page.goto('/login', { waitUntil: 'networkidle' });

    const rootHtml = await page.locator('#app').innerHTML();

    expect(rootHtml.length, 'app harus ter-render').toBeGreaterThan(0);

    const hydrationErrors = errors.filter((e) => /error #418|Hydration failed|hydrat/i.test(e));

    expect(hydrationErrors, hydrationErrors.join(' | ')).toEqual([]);
});
