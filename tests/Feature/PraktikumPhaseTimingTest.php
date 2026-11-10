<?php

namespace Tests\Feature;

use App\Models\Asisten;
use App\Models\Kelas;
use App\Models\Modul;
use App\Models\Praktikum;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PraktikumPhaseTimingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_phase_timer_resets_when_advancing_phase(): void
    {
        $this->actingAsAssistantWithPermissions(['manage-praktikum']);

        $kelas = Kelas::factory()->create();
        $modul = Modul::factory()->create();

        $creationResponse = $this->postJson('/api-v1/praktikum', [
            'kelas_id' => $kelas->id,
            'modul_id' => $modul->id,
            'dk' => 'DK1',
        ]);

        $creationResponse->assertCreated();

        $praktikumId = $creationResponse->json('data.id');

        Carbon::setTestNow(Carbon::parse('2024-01-01 10:00:00'));

        $this->putJson("/api-v1/praktikum/{$praktikumId}", [
            'action' => 'start',
            'phase' => 'preparation',
        ])->assertOk();

        Carbon::setTestNow(Carbon::parse('2024-01-01 10:05:00'));

        $this->putJson("/api-v1/praktikum/{$praktikumId}", [
            'action' => 'next',
            'phase' => 'ta',
        ])->assertOk();

        $praktikum = Praktikum::findOrFail($praktikumId);

        $this->assertSame('ta', $praktikum->current_phase);
        $this->assertSame(0, $praktikum->phase_elapsed_seconds);
        $this->assertNotNull($praktikum->phase_started_at);
        $this->assertTrue($praktikum->phase_started_at->equalTo(Carbon::now()));
    }

    public function test_phase_elapsed_seconds_accumulates_on_pause_and_resets_on_next_phase(): void
    {
        $this->actingAsAssistantWithPermissions(['manage-praktikum']);

        $kelas = Kelas::factory()->create();
        $modul = Modul::factory()->create();

        $creationResponse = $this->postJson('/api-v1/praktikum', [
            'kelas_id' => $kelas->id,
            'modul_id' => $modul->id,
            'dk' => 'DK1',
        ]);

        $creationResponse->assertCreated();

        $praktikumId = $creationResponse->json('data.id');

        Carbon::setTestNow(Carbon::parse('2024-01-01 08:00:00'));

        $this->putJson("/api-v1/praktikum/{$praktikumId}", [
            'action' => 'start',
            'phase' => 'preparation',
        ])->assertOk();

        Carbon::setTestNow(Carbon::parse('2024-01-01 08:03:00'));

        $this->putJson("/api-v1/praktikum/{$praktikumId}", [
            'action' => 'pause',
        ])->assertOk();

        $praktikum = Praktikum::findOrFail($praktikumId);
        $this->assertSame(180, $praktikum->phase_elapsed_seconds);
        $this->assertNull($praktikum->phase_started_at);

        Carbon::setTestNow(Carbon::parse('2024-01-01 08:05:00'));

        $this->putJson("/api-v1/praktikum/{$praktikumId}", [
            'action' => 'resume',
        ])->assertOk();

        $praktikum->refresh();
        $this->assertSame(180, $praktikum->phase_elapsed_seconds);
        $this->assertNotNull($praktikum->phase_started_at);
        $this->assertTrue($praktikum->phase_started_at->equalTo(Carbon::now()));

        Carbon::setTestNow(Carbon::parse('2024-01-01 08:06:30'));

        $this->putJson("/api-v1/praktikum/{$praktikumId}", [
            'action' => 'next',
            'phase' => 'ta',
        ])->assertOk();

        $praktikum->refresh();
        $this->assertSame('ta', $praktikum->current_phase);
        $this->assertSame(0, $praktikum->phase_elapsed_seconds);
        $this->assertTrue($praktikum->phase_started_at->equalTo(Carbon::now()));
    }

    protected function actingAsAssistantWithPermissions(array $permissions): Asisten
    {
        $role = Role::create([
            'name' => 'TEST-PRAKTIKUM-ROLE',
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
