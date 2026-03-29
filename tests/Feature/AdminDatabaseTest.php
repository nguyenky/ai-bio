<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_admin_can_view_the_database_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.database.show'));

        $response->assertOk();
        $response->assertSee('SQLite storage and content overview.');
        $response->assertSee('Manage posts');
        $response->assertSee(config('database.default'));
    }
}
