import { test, expect } from '@playwright/test';
import { readFileSync, existsSync, readdirSync } from 'node:fs';
import { join } from 'node:path';

/**
 * Regresi untuk pemisahan paket Inertia.
 *
 * `@inertiajs/inertia` v0.11 adalah paket usang yang tidak lagi dipakai Inertia
 * v2/v3, mem-pin axios lama, dan membuat `npm audit` melaporkan advisory axios
 * sebagai "tidak ada perbaikan". Seluruh kode harus memakai `@inertiajs/react`.
 */
const JS_ROOT = join(process.cwd(), 'resources', 'js');

function listSourceFiles(dir) {
    return readdirSync(dir, { withFileTypes: true }).flatMap((entry) => {
        const full = join(dir, entry.name);
        if (entry.isDirectory()) {
            return listSourceFiles(full);
        }

        return /\.(js|jsx)$/.test(entry.name) ? [full] : [];
    });
}

test('no frontend source imports the deprecated @inertiajs/inertia package', () => {
    const offenders = listSourceFiles(JS_ROOT).filter((file) =>
        /from\s+['"]@inertiajs\/inertia['"]/.test(readFileSync(file, 'utf8'))
    );

    expect(offenders, 'ganti ke @inertiajs/react').toEqual([]);
});

test('the deprecated @inertiajs/inertia package is not declared in package.json', () => {
    const pkg = JSON.parse(readFileSync(join(process.cwd(), 'package.json'), 'utf8'));
    const declared = {
        ...(pkg.dependencies ?? {}),
        ...(pkg.devDependencies ?? {}),
    };

    expect(Object.keys(declared)).not.toContain('@inertiajs/inertia');
});

test('ModalResetModule reloads the page through the Inertia router', () => {
    const file = join(
        JS_ROOT,
        'Components',
        'Assistants',
        'Modals',
        'ModalResetModule.jsx'
    );

    expect(existsSync(file), `${file} harus ada`).toBe(true);

    const source = readFileSync(file, 'utf8');

    expect(source).toMatch(/from\s+['"]@inertiajs\/react['"]/);
    expect(source).toMatch(/router\.reload\(/);
    expect(source).not.toMatch(/\bInertia\.reload\(/);
});
