<?php

namespace Tests\Feature;

use App\Models\InstagramItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class InstagramImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_bulk_import_instagram_links(): void
    {
        Http::fake([
            'https://www.instagram.com/*' => Http::response(
                <<<'HTML'
                <html>
                    <head>
                        <meta property="og:title" content="Sunset walk on the weekend">
                        <meta property="og:description" content="A warm evening and a quiet street.">
                        <meta property="og:image" content="https://cdn.example.com/post.jpg">
                    </head>
                </html>
                HTML
            ),
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/admin/instagram-items/import', [
            'links' => implode("\n", [
                'https://www.instagram.com/p/ABC123/?utm_source=ig_web_copy_link',
                'https://www.instagram.com/reel/XYZ789/',
            ]),
        ]);

        $response->assertRedirect(route('admin.instagram-items.index'));
        $this->assertDatabaseCount('instagram_items', 2);

        $this->assertDatabaseHas('instagram_items', [
            'instagram_url' => 'https://www.instagram.com/p/ABC123',
            'title' => 'Sunset walk on the weekend',
            'caption' => 'A warm evening and a quiet street.',
            'image_url' => 'https://cdn.example.com/post.jpg',
        ]);
    }

    public function test_bulk_import_rejects_non_post_instagram_links(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->from('/admin/instagram-items')->post('/admin/instagram-items/import', [
            'links' => 'https://www.instagram.com/_ky.lenguyen_/',
        ]);

        $response->assertRedirect('/admin/instagram-items');
        $response->assertSessionHasErrors('links');
        $this->assertDatabaseCount('instagram_items', 0);
    }

    public function test_import_falls_back_when_metadata_fetch_fails(): void
    {
        Http::fake([
            'https://www.instagram.com/*' => Http::response('', 429),
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/admin/instagram-items/import', [
            'links' => 'https://www.instagram.com/reel/XYZ789/',
        ]);

        $response->assertRedirect(route('admin.instagram-items.index'));

        $this->assertDatabaseHas('instagram_items', [
            'instagram_url' => 'https://www.instagram.com/reel/XYZ789',
            'title' => 'Instagram reel',
            'image_url' => null,
        ]);
    }
}
