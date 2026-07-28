<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
    }

    public function test_admin_can_authenticate_with_valid_credentials(): void
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('secret123'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@test.com',
            'password' => 'secret123',
        ]);

        $this->assertAuthenticatedAs($admin, 'web');
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        /** @var \App\Models\User $student */
        $student = User::factory()->create([
            'role' => 'student',
            'status' => 'active',
        ]);

        $response = $this->actingAs($student, 'web')->get(route('admin.dashboard'));

        $this->assertTrue(
            in_array($response->getStatusCode(), [302, 403]),
            "Expected status 302 or 403, but received {$response->getStatusCode()}."
        );
    }
}