<?php

namespace Database\Seeders;

use App\Models\InstagramItem;
use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::current()->update([
            'hero_heading' => 'Stories, notes, and life updates.',
            'short_bio' => 'A personal blog for recent news, thoughtful writing, and curated moments from Instagram.',
            'intro_text' => 'This starter content is here so you can review the layout quickly. You can replace everything later from the admin settings page.',
            'instagram_profile_url' => 'https://www.instagram.com/_ky.lenguyen_/',
            'seo_title' => config('app.name'),
            'seo_description' => 'Personal news, blog posts, and curated Instagram moments.',
        ]);

        if (! Post::exists()) {
            Post::create([
                'title' => 'Launching the new personal site',
                'excerpt' => 'A short welcome note about the first version of this website and what will live here.',
                'body' => "This is the first sample post in the site. Use the admin area to replace this text with your own writing, updates, and personal stories.\n\nThe layout is designed to feel editorial and image-led, while keeping the technical stack simple with Laravel and Bootstrap.",
                'is_featured' => true,
                'published_at' => now(),
            ]);

            Post::create([
                'title' => 'Collecting ideas for future articles',
                'excerpt' => 'A quick behind-the-scenes note about upcoming writing topics and experiments.',
                'body' => 'You can use the journal page for short updates or longer articles. This makes the homepage feel alive even before you publish many full blog posts.',
                'published_at' => now()->subDays(2),
            ]);

            Post::create([
                'title' => 'Why I wanted a personal blog again',
                'excerpt' => 'Notes on building a quiet place online for writing, photos, and personal updates.',
                'body' => 'A personal site gives you a home base that is fully yours. This sample content exists to make review easier while the real content is still being shaped.',
                'published_at' => now()->subDays(5),
            ]);
        }

        if (! InstagramItem::exists()) {
            InstagramItem::insert([
                [
                    'title' => 'Morning light',
                    'caption' => 'A warm first placeholder for the grid.',
                    'image_url' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80',
                    'instagram_url' => 'https://www.instagram.com/_ky.lenguyen_/',
                    'sort_order' => 1,
                    'is_visible' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'City notes',
                    'caption' => 'A second sample image card.',
                    'image_url' => 'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=900&q=80',
                    'instagram_url' => 'https://www.instagram.com/_ky.lenguyen_/',
                    'sort_order' => 2,
                    'is_visible' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Weekend detail',
                    'caption' => 'A third placeholder to complete the section.',
                    'image_url' => 'https://images.unsplash.com/photo-1511988617509-a57c8a288659?auto=format&fit=crop&w=900&q=80',
                    'instagram_url' => 'https://www.instagram.com/_ky.lenguyen_/',
                    'sort_order' => 3,
                    'is_visible' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
