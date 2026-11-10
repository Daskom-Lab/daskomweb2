import { test, expect } from '@playwright/test';
import { readFileSync } from 'node:fs';
import { join } from 'node:path';

/**
 * Inertia v3 mengganti atribut `inertia` pada elemen <head> menjadi
 * `data-inertia`. Atribut lama diabaikan, sehingga <title inertia> berhenti
 * dikelola Inertia dan judul tab menjadi tidak konsisten antar halaman.
 *
 * Sumber: https://inertiajs.com/docs/v3/getting-started/upgrade-guide
 */
const ROOT_VIEW = join(process.cwd(), 'resources', 'views', 'app.blade.php');

test('root view marks head elements with data-inertia, not the legacy attribute', () => {
    const source = readFileSync(ROOT_VIEW, 'utf8');

    expect(source).not.toMatch(/<(\w+)[^>]*\sinertia(\s|>)/);
    expect(source).toMatch(/<title data-inertia>/);
});

test('root view keeps the Inertia app and head directives', () => {
    const source = readFileSync(ROOT_VIEW, 'utf8');

    expect(source).toMatch(/@inertiaHead|@inertia\b/);
});
