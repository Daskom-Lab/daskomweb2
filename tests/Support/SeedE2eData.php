<?php

namespace Tests\Support;

use App\Models\Asisten;
use App\Models\Kelas;
use App\Models\Modul;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Menyiapkan data untuk pengujian E2E Playwright.
 *
 * Berada di tests/ (bukan app/) supaya tidak ikut ter-deploy ke produksi.
 * Dipanggil oleh skrip E2E lewat `php artisan e2e:seed`, dan perintah itu
 * hanya terdaftar ketika lingkungan pengujian memuat helper ini
 * (lihat Tests\TestCase::registerE2eHelpers()).
 */
class SeedE2eData extends Command
{
    protected $signature = 'e2e:seed
                            {--kode=E2E : Kode login asisten (kolom char(3))}
                            {--password=password123 : Password login}';

    protected $description = 'Membuat asisten, kelas, dan modul untuk pengujian E2E';

    private const PERMISSIONS = [
        'manage-modul',
        'lihat-modul',
        'manage-praktikum',
        'see-praktikum',
        'set-praktikan',
        'manage-profile',
        'lms-configuration',
    ];

    public function handle(): int
    {
        $kode = (string) $this->option('kode');
        $password = (string) $this->option('password');

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $role = Role::firstOrCreate([
            'name' => 'E2E-ASISTEN-ROLE',
            'guard_name' => 'asisten',
        ]);

        foreach (self::PERMISSIONS as $name) {
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'asisten',
            ]);
        }

        $role->syncPermissions(self::PERMISSIONS);

        /** @var Asisten $asisten */
        $asisten = Asisten::firstOrNew(['kode' => $kode]);
        $asisten->fill([
            'nama' => 'E2E Asisten',
            'password' => bcrypt($password),
            'role_id' => $role->id,
            'deskripsi' => 'Akun uji E2E',
            'nomor_telepon' => '0000000000',
            'id_line' => '-',
            'instagram' => '-',
        ]);
        $asisten->save();
        $asisten->syncRoles([$role]);

        $kelas = Kelas::firstOrCreate(
            ['kelas' => 'E2E', 'hari' => 'senin', 'shift' => '1'],
            ['totalGroup' => 1, 'isEnglish' => false, 'is_tot' => false]
        );

        $modul = Modul::firstOrCreate(
            ['judul' => 'E2E Modul Praktikum'],
            ['deskripsi' => 'Modul untuk pengujian E2E', 'isEnglish' => false, 'isUnlocked' => true]
        );

        $this->info("E2E user siap: kode={$kode} id={$asisten->id}");
        $this->info("E2E kelas id={$kelas->id}, modul id={$modul->id}");

        return self::SUCCESS;
    }
}
