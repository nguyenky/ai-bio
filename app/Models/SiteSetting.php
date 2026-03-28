<?php

namespace App\Models;

use App\Support\StoresImageUploads;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    protected $fillable = [
        'hero_heading',
        'short_bio',
        'intro_text',
        'profile_image_path',
        'profile_image_url',
        'instagram_profile_url',
        'linkedin_url',
        'github_url',
        'x_url',
        'seo_title',
        'seo_description',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'hero_heading' => 'Thoughts, updates, and visual stories.',
            'short_bio' => 'A personal corner for fresh notes, long-form writing, and selected moments from Instagram.',
            'intro_text' => 'Use this space to introduce yourself, explain what readers can expect, and add a bit of personality to the site.',
            'instagram_profile_url' => 'https://www.instagram.com/_ky.lenguyen_/',
            'seo_title' => config('app.name'),
            'seo_description' => 'Personal updates, blog posts, and curated Instagram moments.',
        ]);
    }

    public function profileImageUrl(): ?string
    {
        if ($this->profile_image_path) {
            return Storage::disk(StoresImageUploads::disk())->url($this->profile_image_path);
        }

        return $this->profile_image_url;
    }
}
