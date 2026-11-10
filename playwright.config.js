import { defineConfig } from '@playwright/test';

/**
 * Test non-browser untuk sumber frontend (analisis statis + build artifact).
 * Berjalan tanpa server: `npx playwright test --config=playwright.config.js`.
 */
export default defineConfig({
    testDir: './tests/js',
    fullyParallel: true,
    reporter: [['list']],
    projects: [
        {
            name: 'node',
        },
    ],
});
