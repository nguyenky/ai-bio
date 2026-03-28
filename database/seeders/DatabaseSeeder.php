<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::query()->firstOrCreate([], [
            'hero_heading' => 'Thoughts, updates, and visual stories.',
            'short_bio' => 'A personal blog for publishing fresh notes, long-form posts, and curated Instagram moments.',
            'intro_text' => 'Welcome to your new site. Update this text from the admin panel to introduce yourself and set the tone for the homepage.',
            'instagram_profile_url' => 'https://www.instagram.com/_ky.lenguyen_/',
            'seo_title' => config('app.name'),
            'seo_description' => 'Personal updates, blog posts, and curated Instagram moments.',
        ]);

        if (! app()->isProduction() && filled(env('ADMIN_PASSWORD'))) {
            User::query()->firstOrCreate([
                'email' => env('ADMIN_EMAIL', 'admin@example.com'),
            ], [
                'name' => env('ADMIN_NAME', 'Site Owner'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
            ]);
        }

        if (! app()->isProduction() && filter_var(env('SEED_DEMO_CONTENT', false), FILTER_VALIDATE_BOOL)) {
            $this->call(DemoContentSeeder::class);
        }
    }
}
