<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\Kelas;
use App\Models\Modul;
use App\Models\SoalTa;
use App\Models\SoalTk;
use App\Models\SoalTp;
use App\Models\Asisten;
use App\Models\Praktikan;
use App\Models\SoalFitb;
use App\Models\SoalJurnal;
use App\Models\SoalMandiri;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //First seeding
        // Modul::factory(20)->create();
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

        //end Of First Seeding

        //////////////////////////////////////////////////////////////

        //Second Seeding
        // Kelas::factory(10)->create();

        // Asisten::factory(10)->create();
        // $asisten = Asisten::factory(90)->withRoles(['SOFTWARE', 'KORDAS', 'WAKORDAS', 'KOORPRAK', 'ADMIN', 'HARDWARE', 'DDC', 'ATC', 'RDC', 'HRD', 'CMD', 'MLC'])->create();

        // DB::table('configurations')->insert([
        //     [
        //         'tp_activation' => 1,
        //         'tubes_activation' => 0,
        //         'polling_activation' => 1,
        //         'secretfeature_activation' => 0,
        //         'registrationPraktikan_activation' => 1,
        //         'registrationAsisten_activation' => 1,
        //         'kode_asisten' => 'BOT',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        // ]);


        // // buat polling
        // $words = [
        //     'Terjaim',
        //     'Terasik',
        //     'Terganteng',
        //     'Tercantik',
        //     'Terjamet',
        //     'Terwibu',
        //     'Tergalak',
        //     'Tergalau',
        //     'Termager',
        //     'Terkocak',
        //     'Tergaring',
        //     'Tersantuy',
        //     'Terimut',
        //     'Tercool',
        //     'Terpelit',
        //     'Terkece',
        //     'Terkpop',
        // ];

        // foreach ($words as $word) {
        //     DB::table('jenis_pollings')->insert([
        //         'judul' => $word,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }

        // // buat kode pelanggaran
        // DB::table('kode_pelanggarans')->insert([
        //     [
        //         'pelanggaran' => 'Belum Input Nilai',
        //         'denda' => "5000",
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]
        // ]);


        //end of second seeding


        //////////////////////////////////////////////////////////////


        // Third Seeding

        // // buat praktikan
        // Praktikan::factory()->count(30)->create();

        


        SoalTp::factory()->count(10)->create(); // Menghasilkan 10 record untuk tabel soal_tps
        SoalTa::factory()->count(10)->create(); // Menghasilkan 10 record untuk tabel soal_tas
        SoalFitb::factory()->count(10)->create(); // Menghasilkan 10 record untuk tabel soal_fitbs
        SoalJurnal::factory()->count(10)->create(); // Menghasilkan 10 record untuk tabel soal_jurnals
        SoalMandiri::factory()->count(10)->create();
        SoalTk::factory()->count(10)->create();


        // end of third seeding

}


}
