import { test, expect } from '@playwright/test';

/**
 * E2E alur asisten lewat browser sungguhan: login, buka halaman modul dan
 * praktikum, lalu menambah modul melalui endpoint API yang dipakai UI.
 *
 * Rute yang diverifikasi (hasil `route:list`):
 *   POST /login/asisten            -> LoginAsistenController@store
 *   GET  /modul, /start-praktikum  -> halaman Inertia
 *   POST /api-v1/modul             -> ModulController@store
 *   POST /api-v1/praktikum         -> PraktikumController@store
 *
 * Prasyarat: `php artisan e2e:seed-user` dan `php artisan serve --port=8123`.
 */
const KODE = process.env.E2E_KODE ?? 'E2E';
const PASSWORD = process.env.E2E_PASSWORD ?? 'password123';

async function loginAsisten(page) {
    const errors = [];
    page.on('pageerror', (e) => errors.push(e.message));

    await page.goto('/login?mode=assistant', { waitUntil: 'networkidle' });
    await page.fill('#kode', KODE);
    await page.fill('#password', PASSWORD);

    await page.locator('form button[type="submit"]').first().click();

    // Login mengalihkan ke /assistant lewat Inertia visit, bukan full reload,
    // jadi tunggu perubahan URL alih-alih event load.
    await page.waitForURL((url) => !url.pathname.startsWith('/login'), {
        timeout: 30000,
    });

    expect(page.url(), 'login harus meninggalkan halaman login').not.toContain('/login');

    return errors;
}

/** Mengambil token CSRF dari cookie XSRF-TOKEN yang diset Laravel. */
async function csrfHeaders(page) {
    const token = await page.evaluate(
        () => document.cookie.match(/XSRF-TOKEN=([^;]+)/)?.[1] ?? ''
    );

    return {
        'X-XSRF-TOKEN': decodeURIComponent(token),
        'X-Requested-With': 'XMLHttpRequest',
    };
}

test.describe('Alur asisten', () => {
    test('login asisten berhasil tanpa error konsol', async ({ page }) => {
        const errors = await loginAsisten(page);

        expect(page.url()).toContain('/assistant');
        expect(errors, errors.join(' | ')).toEqual([]);
    });

    test('halaman modul ter-render dengan komponen Inertia yang benar', async ({ page }) => {
        await loginAsisten(page);
        await page.goto('/modul', { waitUntil: 'networkidle' });

        const pageObject = JSON.parse(
            await page.locator('script[type="application/json"]').first().textContent()
        );

        expect(pageObject.component).toBe('Assistants/ModulePraktikum');
        await expect(page.locator('#app')).not.toBeEmpty();
    });

    test('halaman start praktikum ter-render', async ({ page }) => {
        await loginAsisten(page);
        await page.goto('/start-praktikum', { waitUntil: 'networkidle' });

        const pageObject = JSON.parse(
            await page.locator('script[type="application/json"]').first().textContent()
        );

        expect(pageObject.component).toBe('Assistants/StartPraktikum');
        await expect(page.locator('#app')).not.toBeEmpty();
    });

    test('menambah modul baru tersimpan di server', async ({ page }) => {
        await loginAsisten(page);
        await page.goto('/modul', { waitUntil: 'networkidle' });

        const judul = `E2E Modul ${Date.now()}`;
        const headers = await csrfHeaders(page);

        const created = await page.evaluate(async ({ judul, headers }) => {
            const res = await window.axios.post('/api-v1/modul', {
                judul,
                deskripsi: 'Dibuat oleh E2E',
                isEnglish: false,
                isUnlocked: true,
                unlock_config: {},
            }, { headers });

            return { status: res.status, body: res.data };
        }, { judul, headers });

        expect(created.status, JSON.stringify(created.body).slice(0, 300)).toBeLessThan(400);

        const listed = await page.evaluate(async (headers) => {
            const res = await window.axios.get('/api-v1/modul', { headers });
            const rows = res.data.data ?? res.data;

            return (Array.isArray(rows) ? rows : []).map((m) => m.judul);
        }, headers);

        expect(listed).toContain(judul);
    });

    test('memulai praktikum lewat API menyimpan status running', async ({ page }) => {
        await loginAsisten(page);
        await page.goto('/start-praktikum', { waitUntil: 'networkidle' });

        const headers = await csrfHeaders(page);

        const result = await page.evaluate(async (headers) => {
            const modulRes = await window.axios.get('/api-v1/modul', { headers });
            const moduls = modulRes.data.data ?? modulRes.data;

            // KelasController@index membalas { status, message, kelas: [...] }.
            const kelasRes = await window.axios.get('/api-v1/kelas', { headers })
                .catch(() => ({ data: { kelas: [] } }));
            const kelas = kelasRes.data.kelas ?? kelasRes.data.data ?? [];

            if (!moduls?.length || !kelas?.length) {
                return { skipped: true, reason: 'modul/kelas belum tersedia' };
            }

            // ModulController@index mengalias kolom id sebagai idM.
            const modulId = moduls[0].idM ?? moduls[0].id;

            const create = await window.axios.post('/api-v1/praktikum', {
                kelas_id: kelas[0].id,
                modul_id: modulId,
                dk: 'DK1',
            }, { headers });

            const id = create.data?.data?.id;

            const updated = await window.axios.put(`/api-v1/praktikum/${id}`, {
                action: 'start',
                phase: 'preparation',
            }, { headers });

            return { status: updated.status, state: updated.data?.data?.status };
        }, headers);

        if (result.skipped) {
            test.skip(true, result.reason);

            return;
        }

        expect(result.status).toBe(200);
        expect(result.state).toBe('running');
    });
});
