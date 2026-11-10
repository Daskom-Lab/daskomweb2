<?php

namespace Tests\Feature;

use App\Models\Asisten;
use App\Models\Kelas;
use App\Models\Modul;
use App\Models\Nilai;
use App\Models\Praktikan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AnomalyGradesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class);
    }

    public function test_grades_endpoint_returns_all_results_with_assistant_contact(): void
    {
        $this->actingAsAssistantWithPermissions(['manage-praktikum']);

        $graderRole = Role::create([
            'name' => 'TEST-GRADER-ROLE',
            'guard_name' => 'asisten',
        ]);

        $grader = Asisten::factory()->create([
            'nama' => 'Rika Pratama',
            'kode' => 'RP1',
            'nomor_telepon' => '08123456789',
            'id_line' => 'rika.line',
            'instagram' => 'rika.ig',
            'role_id' => $graderRole->id,
        ]);

        $grader->assignRole($graderRole);

        $kelas = Kelas::factory()->create();
        $modul = Modul::factory()->create();
        $praktikan = Praktikan::factory()->create([
            'kelas_id' => $kelas->id,
        ]);

        foreach (range(1, 3) as $index) {
            Nilai::query()->create([
                'tp' => 81 + $index,
                'ta' => 101 + $index,
                'd1' => 70,
                'd2' => 75,
                'd3' => 80,
                'd4' => 85,
                'l1' => 90,
                'l2' => 95,
                'avg' => 88,
                'modul_id' => $modul->id,
                'kelas_id' => $kelas->id,
                'praktikan_id' => $praktikan->id,
                'asisten_id' => $grader->id,
            ]);
        }

        $response = $this->getJson('/api-v1/anomalies/grades?limit=1&non_multiple=1');

        $response
            ->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonPath('data.0.asisten.nama', 'Rika Pratama')
            ->assertJsonPath('data.0.asisten.kode', 'RP1')
            ->assertJsonPath('data.0.asisten.id_line', 'rika.line')
            ->assertJsonPath('data.0.asisten.nomor_telepon', '08123456789')
            ->assertJsonPath('data.0.asisten.instagram', 'rika.ig');
    }

    protected function actingAsAssistantWithPermissions(array $permissions): Asisten
    {
        $role = Role::create([
            'name' => 'TEST-ANOMALY-ROLE',
            'guard_name' => 'asisten',
        ]);

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'asisten',
            ]);
        }

        $role->syncPermissions($permissions);

        $assistant = Asisten::factory()->create([
            'role_id' => $role->id,
        ]);

        $assistant->assignRole($role);

        $this->actingAs($assistant, 'asisten');

        return $assistant;
    }
}
