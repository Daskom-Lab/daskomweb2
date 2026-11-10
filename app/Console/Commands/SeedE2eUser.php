<?php

namespace App\Console\Commands;

use App\Models\Asisten;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Menyiapkan akun asisten untuk E2E Playwright.
 *
 * Hanya dipakai pada database uji; membuat role berisi permission yang
 * dibutuhkan halaman modul dan praktikum, lalu satu akun asisten dengan
 * kode/password yang sudah diketahui.
 */
class SeedE2eUser extends Command
{
    protected $signature = 'e2e:seed-user
                            {--kode=E2E : Kode login asisten (kolom char(3))}
                            {--password=password123 : Password login}';

    protected $description = 'Membuat asisten beserta role untuk pengujian E2E';

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

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

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

        $kelas = \App\Models\Kelas::firstOrCreate(
            ['kelas' => 'E2E', 'hari' => 'senin', 'shift' => '1'],
            ['totalGroup' => 1, 'isEnglish' => false, 'is_tot' => false]
        );

        $modul = \App\Models\Modul::firstOrCreate(
            ['judul' => 'E2E Modul Praktikum'],
            ['deskripsi' => 'Modul untuk pengujian E2E', 'isEnglish' => false, 'isUnlocked' => true]
        );

        $this->info("E2E user siap: kode={$kode} id={$asisten->id}");
        $this->info("E2E kelas id={$kelas->id}, modul id={$modul->id}");

        return self::SUCCESS;
    }
}
