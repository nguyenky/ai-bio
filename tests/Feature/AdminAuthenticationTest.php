<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_sign_in(): void
    {
        $user = User::create([
            'name' => 'Owner',
            'email' => 'owner@example.com',
            'password' => Hash::make('secret-password'),
        ]);

        $response = $this->post('/admin/login', [
            'email' => $user->email,
            'password' => 'secret-password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_routes_require_authentication(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect(route('admin.login'));
    }
}
