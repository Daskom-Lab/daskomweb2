<?php

namespace Tests\Feature;

use App\Models\Asisten;
use App\Models\AuditLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AssistantAuditLogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class);
    }

    /**
     * @param  list<string>  $permissions
     */
    private function actingAsAssistant(array $permissions = []): Asisten
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

    public function test_profile_update_request_is_logged(): void
    {
        $assistant = $this->actingAsAssistant(['manage-profile']);

        $payload = [
            'nomor_telepon' => '08123456789',
            'id_line' => 'assistant_line',
            'instagram' => 'assistant_ig',
            'deskripsi' => 'Updated description',
        ];

        $response = $this
            ->from('/assistant')
            ->put('/api-v1/asisten', $payload);

        $response->assertRedirect('/assistant');

        $log = AuditLog::latest()->first();

        $this->assertNotNull($log);
        $this->assertSame($assistant->id, $log->asisten_id);
        $this->assertSame('assistant.profile.update', $log->action);
        $this->assertSame('update.asisten', $log->route);
        $this->assertSame('PUT', $log->method);
        $this->assertSame('Updated assistant profile information.', $log->description);
        $this->assertSame('assistant_line', data_get($log->metadata, 'payload.id_line'));
        $this->assertSame('assistant_ig', data_get($log->metadata, 'payload.instagram'));
    }

    public function test_password_update_request_redacts_sensitive_values(): void
    {
        $assistant = $this->actingAsAssistant();

        $response = $this
            ->from('/assistant')
            ->patch('/api-v1/asisten/password', [
                'current_password' => 'password',
                'password' => 'password123',
            ]);

        $response->assertRedirect('/assistant');

        $log = AuditLog::latest()->first();

        $this->assertNotNull($log);
        $this->assertSame($assistant->id, $log->asisten_id);
        $this->assertSame('assistant.password.update', $log->action);
        $this->assertSame('asisten.password.update', $log->route);
        $this->assertSame('PATCH', $log->method);
        $this->assertSame('Updated assistant password.', $log->description);
        $this->assertSame('[REDACTED]', data_get($log->metadata, 'payload.current_password'));
        $this->assertSame('[REDACTED]', data_get($log->metadata, 'payload.password'));
    }
}
