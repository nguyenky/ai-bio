<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_shows_only_published_posts(): void
    {
        SiteSetting::current();

        Post::create([
            'title' => 'Published Post',
            'excerpt' => 'Visible excerpt',
            'body' => 'Visible body',
            'published_at' => now(),
        ]);

        Post::create([
            'title' => 'Draft Post',
            'excerpt' => 'Hidden excerpt',
            'body' => 'Hidden body',
            'published_at' => null,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Published Post');
        $response->assertDontSee('Draft Post');
    }

    public function test_post_detail_returns_404_for_unpublished_posts(): void
    {
        $post = Post::create([
            'title' => 'Private Draft',
            'excerpt' => 'Hidden excerpt',
            'body' => 'Hidden body',
            'published_at' => null,
        ]);

        $response = $this->get('/posts/'.$post->slug);

        $response->assertNotFound();
    }
}
