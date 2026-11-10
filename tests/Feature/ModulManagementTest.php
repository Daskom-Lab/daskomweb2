<?php

namespace Tests\Feature;

use App\Models\Asisten;
use App\Models\Modul;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ModulManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class);
    }

    protected function actingAsAssistantWithPermissions(array $permissions): Asisten
    {
        $role = Role::create([
            'name' => 'TEST-ROLE',
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

    public function test_assistant_can_create_module_with_learning_point(): void
    {
        $this->actingAsAssistantWithPermissions(['manage-modul']);

        $payload = [
            'judul' => 'Modul Integrasi',
            'deskripsi' => 'Mahasiswa mampu memahami konsep integral.',
            'isEnglish' => 0,
            'isUnlocked' => 1,
            'modul_link' => 'https://example.com/modul.pdf',
            'ppt_link' => 'https://example.com/slides.pptx',
            'video_link' => 'https://youtu.be/example',
        ];

        $session = $this->app['session'];
        $session->start();
        $token = $session->token();

        $response = $this->post('/api-v1/modul', $payload + ['_token' => $token]);

        $response->assertRedirect();

        $this->assertDatabaseHas('moduls', [
            'judul' => $payload['judul'],
            'deskripsi' => $payload['deskripsi'],
        ]);
    }

    public function test_learning_point_is_required_when_creating_module(): void
    {
        $this->actingAsAssistantWithPermissions(['manage-modul']);

        $payload = [
            'judul' => 'Modul Tanpa Poin',
            'isEnglish' => 0,
            'isUnlocked' => 0,
        ];

        $session = $this->app['session'];
        $session->start();
        $token = $session->token();

        $response = $this->from('/modul')->post('/api-v1/modul', $payload + ['_token' => $token]);

        $response
            ->assertRedirect('/modul')
            ->assertSessionHasErrors(['deskripsi']);

        $this->assertDatabaseMissing('moduls', [
            'judul' => $payload['judul'],
        ]);
    }

    public function test_bulk_update_accepts_top_level_array_payload(): void
    {
        $this->actingAsAssistantWithPermissions(['manage-modul']);

        $modules = Modul::factory()->count(2)->create([
            'isUnlocked' => false,
            'isEnglish' => false,
        ]);

        $payload = $modules
            ->map(fn (Modul $module) => [
                'id' => $module->id,
                'isUnlocked' => 1,
                'isEnglish' => 1,
            ])
            ->all();

        $response = $this->patchJson('/api-v1/modul/bulk-update', $payload);

        $response
            ->assertOk()
            ->assertJson([
                'message' => 'Bulk update berhasil',
                'updated' => 2,
            ]);

        foreach ($modules as $module) {
            $this->assertDatabaseHas('moduls', [
                'id' => $module->id,
                'isUnlocked' => true,
                'isEnglish' => true,
            ]);
        }
    }

    public function test_bulk_update_requires_valid_module_ids(): void
    {
        $this->actingAsAssistantWithPermissions(['manage-modul']);

        $response = $this->patchJson('/api-v1/modul/bulk-update', [
            ['id' => 9999, 'isUnlocked' => 1],
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'Validasi gagal.',
            ])
            ->assertJsonValidationErrors(['payload.0.id']);
    }
}
