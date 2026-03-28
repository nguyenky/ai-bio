<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateAdminUserCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_an_admin_user_from_the_command(): void
    {
        $this->artisan('app:create-admin owner@example.com --name="Site Owner" --password="secret-password"')
            ->expectsOutput('Admin user ready: owner@example.com')
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'email' => 'owner@example.com',
            'name' => 'Site Owner',
        ]);

        $this->assertTrue(
            Hash::check('secret-password', User::where('email', 'owner@example.com')->firstOrFail()->password)
        );
    }
}
