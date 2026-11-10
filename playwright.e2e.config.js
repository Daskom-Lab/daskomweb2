import { defineConfig, devices } from '@playwright/test';

/**
 * Test browser (Chromium) terhadap aplikasi yang sudah berjalan.
 *
 * Jalankan server lebih dulu, lalu:
 *   E2E_BASE_URL=http://127.0.0.1:8123 npx playwright test --config=playwright.e2e.config.js
 */
const baseURL = process.env.E2E_BASE_URL ?? 'http://127.0.0.1:8123';

export default defineConfig({
    testDir: './tests/e2e',
    fullyParallel: false,
    workers: 1,
    timeout: 60_000,
    reporter: [['list']],
    use: {
        baseURL,
        trace: 'retain-on-failure',
    },
    projects: [
        {
            name: 'chromium',
            use: { ...devices['Desktop Chrome'] },
        },
    ],
});
