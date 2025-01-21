<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // aslab Pro Ultra
        //List of permissions to create
        // $permissions = [
        //     // 'super-aslab',
        //     // 'aslab-features',
        //     // 'ddc-features',
        //     // 'atc-features',
        //     // 'rdc-features',
        //     // 'asisten-features',
        //     'manage-role',
        //     'manage-praktikum',
        //     'laporan-praktikum',
        //     'manage-plot',
        //     'manage-pelanggaran',
        //     'manage-modul',
        //     'manage-soal',
        //     'unlock-jawaban',
        //     'tugas-pendahuluan',
        //     'see-pelanggaran',
        //     'lms-configuration',
        //     'manage-profile',
        //     'see-praktikum',
        //     'see-history',
        //     'see-soal',
        //     'nilai-praktikan',
        //     'see-plot',
        //     'ranking-praktikan',
        //     'see-polling',
        //     'set-praktikan',
        //     'reset-praktikan',
        //     'check-tugas-pendahuluan',
        //     'change-password',
        //     'praktikan-regist',
        //     'tp-configuration',
        //     'logout',
        // ];

        // Role::create(['name' => 'SOFTWARE', 'guard_name' => 'asisten', 'created_at' => now(), 'updated_at' => now()]);
        // Role::create(['name' => 'KORDAS', 'guard_name' => 'asisten', 'created_at' => now(), 'updated_at' => now()]);
        // Role::create(['name' => 'WAKORDAS', 'guard_name' => 'asisten', 'created_at' => now(), 'updated_at' => now()]);
        // Role::create(['name' => 'KOORPRAK', 'guard_name' => 'asisten', 'created_at' => now(), 'updated_at' => now()]);
        // Role::create(['name' => 'ADMIN', 'guard_name' => 'asisten', 'created_at' => now(), 'updated_at' => now()]);
        // Role::create(['name' => 'HARDWARE', 'guard_name' => 'asisten', 'created_at' => now(), 'updated_at' => now()]);
        // Role::create(['name' => 'DDC', 'guard_name' => 'asisten', 'created_at' => now(), 'updated_at' => now()]);
        // Role::create(['name' => 'ATC', 'guard_name' => 'asisten', 'created_at' => now(), 'updated_at' => now()]);
        // Role::create(['name' => 'RDC', 'guard_name' => 'asisten', 'created_at' => now(), 'updated_at' => now()]);
        // Role::create(['name' => 'HRD', 'guard_name' => 'asisten', 'created_at' => now(), 'updated_at' => now()]);
        // Role::create(['name' => 'CMD', 'guard_name' => 'asisten', 'created_at' => now(), 'updated_at' => now()]);
        // Role::create(['name' => 'MLC', 'guard_name' => 'asisten', 'created_at' => now(), 'updated_at' => now()]);

        // // Create permissions
        // foreach ($permissions as $permission) {
        //     Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'asisten', 'created_at' => now(), 'updated_at' => now()]);
        // }

        // Role::create(['name' => 'PRAKTIKAN', 'guard_name' => 'praktikan', 'created_at' => now(), 'updated_at' => now()]);
        // Permission::create(['name' => 'lihat-profile', 'guard_name' => 'praktikan', 'created_at' => now(), 'updated_at' => now()]);
        // Permission::create(['name' => 'lihat-nilai', 'guard_name' => 'praktikan', 'created_at' => now(), 'updated_at' => now()]);
        // Permission::create(['name' => 'lihat-modul', 'guard_name' => 'praktikan', 'created_at' => now(), 'updated_at' => now()]);
        // Permission::create(['name' => 'lihat-asisten', 'guard_name' => 'praktikan', 'created_at' => now(), 'updated_at' => now()]);
        // Permission::create(['name' => 'praktikum-lms', 'guard_name' => 'praktikan', 'created_at' => now(), 'updated_at' => now()]);
        // Permission::create(['name' => 'lihat-leaderboard', 'guard_name' => 'praktikan', 'created_at' => now(), 'updated_at' => now()]);
        // Permission::create(['name' => 'isi-polling', 'guard_name' => 'praktikan', 'created_at' => now(), 'updated_at' => now()]);
        // Permission::create(['name' => 'ganti-password', 'guard_name' => 'praktikan', 'created_at' => now(), 'updated_at' => now()]);
        Permission::create(['name' => 'logout-praktikan', 'guard_name' => 'praktikan', 'created_at' => now(), 'updated_at' => now()]);



        $role = Role::firstOrCreate(['name' => 'PRAKTIKAN', 'guard_name' => 'praktikan']);

        $role->givePermissionTo([
            // 'lihat-profile',
            // 'lihat-nilai',
            // 'lihat-modul',
            // 'lihat-asisten',
            // 'praktikum-lms',
            // 'lihat-leaderboard',
            // 'isi-polling',
            // 'ganti-password',
            'logout-praktikan'
        ]);


        // $AslabProUltra = Role::firstOrCreate(['name' => 'SOFTWARE', 'guard_name' => 'asisten']);

        // $Kordas = Role::firstOrCreate(['name' => 'KORDAS', 'guard_name' => 'asisten']);

        // $Wakordas = Role::firstOrCreate(['name' => 'WAKORDAS', 'guard_name' => 'asisten']);

        // $Koorprak = Role::firstOrCreate(['name' => 'KOORPRAK', 'guard_name' => 'asisten']);

        // $Admin = Role::firstOrCreate(['name' => 'ADMIN', 'guard_name' => 'asisten']);

        // $Hardware = Role::firstOrCreate(['name' => 'HARDWARE', 'guard_name' => 'asisten']);


        // $AsistenSemiUltra = Role::firstOrCreate(['name' => 'DDC', 'guard_name' => 'asisten']);

        // $AsprakATC = Role::firstOrCreate(['name' => 'ATC', 'guard_name' => 'asisten']);

        // $AsprakRDC = Role::firstOrCreate(['name' => 'RDC', 'guard_name' => 'asisten']);

        // $AsprakCMD = Role::firstOrCreate(['name' => 'CMD', 'guard_name' => 'asisten']);

        // $AsprakHRD = Role::firstOrCreate(['name' => 'HRD', 'guard_name' => 'asisten']);

        // $AsprakMLC = Role::firstOrCreate(['name' => 'MLC', 'guard_name' => 'asisten']);


        // $AslabProUltra->givePermissionTo('manage-role');
        // $AslabProUltra->givePermissionTo('manage-praktikum');
        // $AslabProUltra->givePermissionTo('laporan-praktikum');
        // $AslabProUltra->givePermissionTo('manage-plot');
        // $AslabProUltra->givePermissionTo('manage-pelanggaran');
        // $AslabProUltra->givePermissionTo('manage-modul');
        // $AslabProUltra->givePermissionTo('manage-soal');
        // $AslabProUltra->givePermissionTo('unlock-jawaban');
        // $AslabProUltra->givePermissionTo('tugas-pendahuluan');
        // $AslabProUltra->givePermissionTo('lms-configuration');
        // $AslabProUltra->givePermissionTo('manage-profile');
        // $AslabProUltra->givePermissionTo('see-praktikum');
        // $AslabProUltra->givePermissionTo('see-history');
        // $AslabProUltra->givePermissionTo('see-soal');
        // $AslabProUltra->givePermissionTo('nilai-praktikan');
        // $AslabProUltra->givePermissionTo('see-plot');
        // $AslabProUltra->givePermissionTo('ranking-praktikan');
        // $AslabProUltra->givePermissionTo('see-polling');
        // $AslabProUltra->givePermissionTo('see-pelanggaran');
        // $AslabProUltra->givePermissionTo('set-praktikan');
        // $AslabProUltra->givePermissionTo('reset-praktikan');
        // $AslabProUltra->givePermissionTo('check-tugas-pendahuluan');
        // $AslabProUltra->givePermissionTo('change-password');
        // $AslabProUltra->givePermissionTo('tp-configuration');
        // $AslabProUltra->givePermissionTo('praktikan-regist');
        // $AslabProUltra->givePermissionTo('logout');

        // $Kordas->givePermissionTo('manage-role');
        // $Kordas->givePermissionTo('manage-praktikum');
        // $Kordas->givePermissionTo('laporan-praktikum');
        // $Kordas->givePermissionTo('manage-plot');
        // $Kordas->givePermissionTo('manage-pelanggaran');
        // $Kordas->givePermissionTo('manage-modul');
        // $Kordas->givePermissionTo('manage-soal');
        // $Kordas->givePermissionTo('unlock-jawaban');
        // $Kordas->givePermissionTo('tugas-pendahuluan');
        // $Kordas->givePermissionTo('lms-configuration');
        // $Kordas->givePermissionTo('manage-profile');
        // $Kordas->givePermissionTo('see-praktikum');
        // $Kordas->givePermissionTo('see-history');
        // $Kordas->givePermissionTo('see-soal');
        // $Kordas->givePermissionTo('nilai-praktikan');
        // $Kordas->givePermissionTo('see-plot');
        // $Kordas->givePermissionTo('ranking-praktikan');
        // $Kordas->givePermissionTo('see-polling');
        // $Kordas->givePermissionTo('see-pelanggaran');
        // $Kordas->givePermissionTo('set-praktikan');
        // $Kordas->givePermissionTo('reset-praktikan');
        // $Kordas->givePermissionTo('check-tugas-pendahuluan');
        // $Kordas->givePermissionTo('change-password');
        // $Kordas->givePermissionTo('tp-configuration');
        // $Kordas->givePermissionTo('praktikan-regist');
        // $Kordas->givePermissionTo('logout');

        // $Wakordas->givePermissionTo('manage-role');
        // $Wakordas->givePermissionTo('manage-praktikum');
        // $Wakordas->givePermissionTo('laporan-praktikum');
        // $Wakordas->givePermissionTo('manage-plot');
        // $Wakordas->givePermissionTo('manage-pelanggaran');
        // $Wakordas->givePermissionTo('manage-modul');
        // $Wakordas->givePermissionTo('manage-soal');
        // $Wakordas->givePermissionTo('unlock-jawaban');
        // $Wakordas->givePermissionTo('tugas-pendahuluan');
        // $Wakordas->givePermissionTo('lms-configuration');
        // $Wakordas->givePermissionTo('manage-profile');
        // $Wakordas->givePermissionTo('see-praktikum');
        // $Wakordas->givePermissionTo('see-history');
        // $Wakordas->givePermissionTo('see-soal');
        // $Wakordas->givePermissionTo('nilai-praktikan');
        // $Wakordas->givePermissionTo('see-plot');
        // $Wakordas->givePermissionTo('ranking-praktikan');
        // $Wakordas->givePermissionTo('see-polling');
        // $Wakordas->givePermissionTo('see-pelanggaran');
        // $Wakordas->givePermissionTo('set-praktikan');
        // $Wakordas->givePermissionTo('reset-praktikan');
        // $Wakordas->givePermissionTo('check-tugas-pendahuluan');
        // $Wakordas->givePermissionTo('change-password');
        // $Wakordas->givePermissionTo('tp-configuration');
        // $Wakordas->givePermissionTo('praktikan-regist');
        // $Wakordas->givePermissionTo('logout');

        // $Koorprak->givePermissionTo('manage-praktikum');
        // $Koorprak->givePermissionTo('laporan-praktikum');
        // $Koorprak->givePermissionTo('manage-plot');
        // $Koorprak->givePermissionTo('manage-pelanggaran');
        // $Koorprak->givePermissionTo('manage-modul');
        // $Koorprak->givePermissionTo('manage-soal');
        // $Koorprak->givePermissionTo('unlock-jawaban');
        // $Koorprak->givePermissionTo('tugas-pendahuluan');
        // $Koorprak->givePermissionTo('lms-configuration');
        // $Koorprak->givePermissionTo('manage-profile');
        // $Koorprak->givePermissionTo('see-praktikum');
        // $Koorprak->givePermissionTo('see-history');
        // $Koorprak->givePermissionTo('see-soal');
        // $Koorprak->givePermissionTo('nilai-praktikan');
        // $Koorprak->givePermissionTo('see-plot');
        // $Koorprak->givePermissionTo('ranking-praktikan');
        // $Koorprak->givePermissionTo('see-polling');
        // $Koorprak->givePermissionTo('see-pelanggaran');
        // $Koorprak->givePermissionTo('set-praktikan');
        // $Koorprak->givePermissionTo('reset-praktikan');
        // $Koorprak->givePermissionTo('check-tugas-pendahuluan');
        // $Koorprak->givePermissionTo('change-password');
        // $Koorprak->givePermissionTo('tp-configuration');
        // $Koorprak->givePermissionTo('praktikan-regist');
        // $Koorprak->givePermissionTo('logout');

        // $Admin->givePermissionTo('manage-praktikum');
        // $Admin->givePermissionTo('laporan-praktikum');
        // $Admin->givePermissionTo('manage-plot');
        // $Admin->givePermissionTo('manage-pelanggaran');
        // $Admin->givePermissionTo('manage-modul');
        // $Admin->givePermissionTo('manage-soal');
        // $Admin->givePermissionTo('unlock-jawaban');
        // $Admin->givePermissionTo('tugas-pendahuluan');
        // $Admin->givePermissionTo('lms-configuration');
        // $Admin->givePermissionTo('manage-profile');
        // $Admin->givePermissionTo('see-praktikum');
        // $Admin->givePermissionTo('see-history');
        // $Admin->givePermissionTo('see-soal');
        // $Admin->givePermissionTo('nilai-praktikan');
        // $Admin->givePermissionTo('see-plot');
        // $Admin->givePermissionTo('ranking-praktikan');
        // $Admin->givePermissionTo('see-polling');
        // $Admin->givePermissionTo('see-pelanggaran');
        // $Admin->givePermissionTo('set-praktikan');
        // $Admin->givePermissionTo('reset-praktikan');
        // $Admin->givePermissionTo('check-tugas-pendahuluan');
        // $Admin->givePermissionTo('change-password');
        // $Admin->givePermissionTo('tp-configuration');
        // $Admin->givePermissionTo('praktikan-regist');
        // $Admin->givePermissionTo('logout');

        // $Hardware->givePermissionTo('manage-praktikum');
        // $Hardware->givePermissionTo('laporan-praktikum');
        // $Hardware->givePermissionTo('manage-plot');
        // $Hardware->givePermissionTo('manage-pelanggaran');
        // $Hardware->givePermissionTo('manage-modul');
        // $Hardware->givePermissionTo('manage-soal');
        // $Hardware->givePermissionTo('unlock-jawaban');
        // $Hardware->givePermissionTo('tugas-pendahuluan');
        // $Hardware->givePermissionTo('lms-configuration');
        // $Hardware->givePermissionTo('manage-profile');
        // $Hardware->givePermissionTo('see-praktikum');
        // $Hardware->givePermissionTo('see-history');
        // $Hardware->givePermissionTo('see-soal');
        // $Hardware->givePermissionTo('nilai-praktikan');
        // $Hardware->givePermissionTo('see-plot');
        // $Hardware->givePermissionTo('ranking-praktikan');
        // $Hardware->givePermissionTo('see-polling');
        // $Hardware->givePermissionTo('see-pelanggaran');
        // $Hardware->givePermissionTo('set-praktikan');
        // $Hardware->givePermissionTo('reset-praktikan');
        // $Hardware->givePermissionTo('check-tugas-pendahuluan');
        // $Hardware->givePermissionTo('change-password');
        // $Hardware->givePermissionTo('tp-configuration');
        // $Hardware->givePermissionTo('praktikan-regist');
        // $Hardware->givePermissionTo('logout');


        // $AsistenSemiUltra->givePermissionTo('manage-profile');
        // $AsistenSemiUltra->givePermissionTo('see-praktikum');
        // $AsistenSemiUltra->givePermissionTo('see-history');
        // $AsistenSemiUltra->givePermissionTo('see-soal');
        // $AsistenSemiUltra->givePermissionTo('nilai-praktikan');
        // $AsistenSemiUltra->givePermissionTo('see-plot');
        // $AsistenSemiUltra->givePermissionTo('ranking-praktikan');
        // $AsistenSemiUltra->givePermissionTo('see-polling');
        // $AsistenSemiUltra->givePermissionTo('see-pelanggaran');
        // $AsistenSemiUltra->givePermissionTo('set-praktikan');
        // $AsistenSemiUltra->givePermissionTo('reset-praktikan');
        // $AsistenSemiUltra->givePermissionTo('check-tugas-pendahuluan');
        // $AsistenSemiUltra->givePermissionTo('change-password');
        // $AsistenSemiUltra->givePermissionTo('logout');
        // $AsistenSemiUltra->givePermissionTo('manage-modul');
        // $AsistenSemiUltra->givePermissionTo('manage-soal');
        // $AsistenSemiUltra->givePermissionTo('unlock-jawaban');
        // $AsistenSemiUltra->givePermissionTo('manage-praktikum');
        // $AsistenSemiUltra->givePermissionTo('see-pelanggaran');
        // $AsistenSemiUltra->givePermissionTo('tugas-pendahuluan');
        // $AsistenSemiUltra->givePermissionTo('tp-configuration');
        // $AsistenSemiUltra->givePermissionTo('praktikan-regist');


        // $AsprakATC->givePermissionTo('manage-profile');
        // $AsprakATC->givePermissionTo('see-praktikum');
        // $AsprakATC->givePermissionTo('see-history');
        // $AsprakATC->givePermissionTo('see-soal');
        // $AsprakATC->givePermissionTo('nilai-praktikan');
        // $AsprakATC->givePermissionTo('see-plot');
        // $AsprakATC->givePermissionTo('ranking-praktikan');
        // $AsprakATC->givePermissionTo('see-polling');
        // $AsprakATC->givePermissionTo('see-pelanggaran');
        // $AsprakATC->givePermissionTo('set-praktikan');
        // $AsprakATC->givePermissionTo('reset-praktikan');
        // $AsprakATC->givePermissionTo('check-tugas-pendahuluan');
        // $AsprakATC->givePermissionTo('change-password');
        // $AsprakATC->givePermissionTo('logout');
        // $AsprakATC->givePermissionTo('manage-modul');
        // $AsprakATC->givePermissionTo('manage-soal');
        // $AsprakATC->givePermissionTo('unlock-jawaban');
        // $AsprakATC->givePermissionTo('tugas-pendahuluan');

        // $AsprakRDC->givePermissionTo('manage-profile');
        // $AsprakRDC->givePermissionTo('see-praktikum');
        // $AsprakRDC->givePermissionTo('see-history');
        // $AsprakRDC->givePermissionTo('see-soal');
        // $AsprakRDC->givePermissionTo('nilai-praktikan');
        // $AsprakRDC->givePermissionTo('see-plot');
        // $AsprakRDC->givePermissionTo('ranking-praktikan');
        // $AsprakRDC->givePermissionTo('see-polling');
        // $AsprakRDC->givePermissionTo('see-pelanggaran');
        // $AsprakRDC->givePermissionTo('set-praktikan');
        // $AsprakRDC->givePermissionTo('reset-praktikan');
        // $AsprakRDC->givePermissionTo('check-tugas-pendahuluan');
        // $AsprakRDC->givePermissionTo('change-password');
        // $AsprakRDC->givePermissionTo('logout');
        // $AsprakRDC->givePermissionTo('manage-praktikum');
        // $AsprakRDC->givePermissionTo('tp-configuration');
        // $AsprakRDC->givePermissionTo('praktikan-regist');
        // $AsprakRDC->givePermissionTo('see-pelanggaran');

        // $AsprakCMD->givePermissionTo('manage-profile');
        // $AsprakCMD->givePermissionTo('see-praktikum');
        // $AsprakCMD->givePermissionTo('see-history');
        // $AsprakCMD->givePermissionTo('see-soal');
        // $AsprakCMD->givePermissionTo('nilai-praktikan');
        // $AsprakCMD->givePermissionTo('see-plot');
        // $AsprakCMD->givePermissionTo('ranking-praktikan');
        // $AsprakCMD->givePermissionTo('see-polling');
        // $AsprakCMD->givePermissionTo('see-pelanggaran');
        // $AsprakCMD->givePermissionTo('set-praktikan');
        // $AsprakCMD->givePermissionTo('reset-praktikan');
        // $AsprakCMD->givePermissionTo('check-tugas-pendahuluan');
        // $AsprakCMD->givePermissionTo('change-password');
        // $AsprakCMD->givePermissionTo('logout');

        // $AsprakHRD->givePermissionTo('manage-profile');
        // $AsprakHRD->givePermissionTo('see-praktikum');
        // $AsprakHRD->givePermissionTo('see-history');
        // $AsprakHRD->givePermissionTo('see-soal');
        // $AsprakHRD->givePermissionTo('nilai-praktikan');
        // $AsprakHRD->givePermissionTo('see-plot');
        // $AsprakHRD->givePermissionTo('ranking-praktikan');
        // $AsprakHRD->givePermissionTo('see-polling');
        // $AsprakHRD->givePermissionTo('see-pelanggaran');
        // $AsprakHRD->givePermissionTo('set-praktikan');
        // $AsprakHRD->givePermissionTo('reset-praktikan');
        // $AsprakHRD->givePermissionTo('check-tugas-pendahuluan');
        // $AsprakHRD->givePermissionTo('change-password');
        // $AsprakHRD->givePermissionTo('logout');

        // $AsprakMLC->givePermissionTo('manage-profile');
        // $AsprakMLC->givePermissionTo('see-praktikum');
        // $AsprakMLC->givePermissionTo('see-history');
        // $AsprakMLC->givePermissionTo('see-soal');
        // $AsprakMLC->givePermissionTo('nilai-praktikan');
        // $AsprakMLC->givePermissionTo('see-plot');
        // $AsprakMLC->givePermissionTo('ranking-praktikan');
        // $AsprakMLC->givePermissionTo('see-polling');
        // $AsprakMLC->givePermissionTo('see-pelanggaran');
        // $AsprakMLC->givePermissionTo('set-praktikan');
        // $AsprakMLC->givePermissionTo('reset-praktikan');
        // $AsprakMLC->givePermissionTo('check-tugas-pendahuluan');
        // $AsprakMLC->givePermissionTo('change-password');
        // $AsprakMLC->givePermissionTo('logout');

    }
}
