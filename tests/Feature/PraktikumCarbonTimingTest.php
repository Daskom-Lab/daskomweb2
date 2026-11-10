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

/**
 * Karakterisasi timer praktikum terhadap perubahan semantik Carbon 3 di mana
 * `diffIn*` mengembalikan nilai bertanda (signed) alih-alih absolut.
 *
 * Timestamp `started_at` dapat berada di masa depan setelah `next()` /
 * `resume()`, sehingga hasil `diffInSeconds` wajib dihitung absolut.
 */
class PraktikumCarbonTimingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_pause_accrues_elapsed_seconds_when_started_at_is_in_the_future(): void
    {
        $praktikum = $this->createPraktikumWithFutureStart('2024-01-01 09:00:00');

        $this->freezeStartedAt($praktikum, Carbon::parse('2024-01-01 10:00:00'));

        Carbon::setTestNow(Carbon::parse('2024-01-01 09:57:00'));

        $this->putJson("/api-v1/praktikum/{$praktikum->id}", [
            'action' => 'pause',
        ])->assertOk();

        $praktikum->refresh();

        $this->assertSame('paused', $praktikum->status);
        $this->assertSame(180, $praktikum->phase_elapsed_seconds);
        $this->assertSame(
            180.0,
            $praktikum->started_at->diffInSeconds($praktikum->ended_at, absolute: true)
        );
    }

    public function test_resume_preserves_elapsed_seconds_when_started_at_is_in_the_future(): void
    {
        $praktikum = $this->createPraktikumWithFutureStart('2024-01-01 09:00:00');

        $praktikum->forceFill([
            'status' => 'paused',
            'isActive' => false,
            'started_at' => Carbon::parse('2024-01-01 10:00:00'),
            'ended_at' => Carbon::parse('2024-01-01 09:57:00'),
            'phase_started_at' => null,
            'phase_elapsed_seconds' => 0,
        ])->save();

        Carbon::setTestNow(Carbon::parse('2024-01-01 09:58:00'));

        $this->putJson("/api-v1/praktikum/{$praktikum->id}", [
            'action' => 'resume',
        ])->assertOk();

        $praktikum->refresh();

        $this->assertSame('running', $praktikum->status);
        $this->assertTrue(
            $praktikum->started_at->equalTo(Carbon::parse('2024-01-01 09:55:00')),
            'started_at must be shifted back by the 180 elapsed seconds'
        );
    }

    public function test_next_phase_shifts_started_at_using_absolute_elapsed(): void
    {
        $praktikum = $this->createPraktikumWithFutureStart('2024-01-01 09:00:00');

        $this->freezeStartedAt($praktikum, Carbon::parse('2024-01-01 10:00:00'));

        Carbon::setTestNow(Carbon::parse('2024-01-01 09:55:00'));

        $this->putJson("/api-v1/praktikum/{$praktikum->id}", [
            'action' => 'next',
            'phase' => 'ta',
        ])->assertOk();

        $praktikum->refresh();

        $this->assertSame('ta', $praktikum->current_phase);
        $this->assertTrue(
            $praktikum->started_at->equalTo(Carbon::parse('2024-01-01 09:50:00')),
            'started_at must be shifted back by 300 seconds'
        );
    }

    private function freezeStartedAt(Praktikum $praktikum, Carbon $startedAt): void
    {
        $praktikum->forceFill([
            'status' => 'running',
            'isActive' => true,
            'started_at' => $startedAt,
            'ended_at' => null,
            'phase_started_at' => $startedAt,
            'phase_elapsed_seconds' => 0,
        ])->save();
    }

    private function createPraktikumWithFutureStart(string $phaseStartedAt): Praktikum
    {
        $role = Role::create([
            'name' => 'TEST-CARBON-ROLE',
            'guard_name' => 'asisten',
        ]);

        foreach (['manage-praktikum'] as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'asisten',
            ]);
        }

        $role->syncPermissions(['manage-praktikum']);

        /** @var Asisten $assistant */
        $assistant = Asisten::factory()->create([
            'role_id' => $role->id,
        ]);
        $assistant->assignRole($role);

        $this->actingAs($assistant, 'asisten');

        $kelas = Kelas::factory()->create();
        $modul = Modul::factory()->create();

        return Praktikum::create([
            'kelas_id' => $kelas->id,
            'modul_id' => $modul->id,
            'dk' => 'DK1',
            'status' => 'idle',
            'current_phase' => 'preparation',
            'phase_elapsed_seconds' => 0,
            'phase_started_at' => Carbon::parse($phaseStartedAt),
            'isActive' => false,
            'started_at' => null,
            'ended_at' => null,
        ]);
    }
}
