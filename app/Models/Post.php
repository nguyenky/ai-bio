<?php

namespace App\Models;

use App\Support\StoresImageUploads;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'hero_image_path',
        'hero_image_url',
        'is_featured',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Post $post): void {
            if (! $post->title) {
                return;
            }

            if (! $post->slug || $post->isDirty('title')) {
                $post->slug = static::generateUniqueSlug($post->title, $post->id);
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function heroImageUrl(): ?string
    {
        if ($this->hero_image_path) {
            return Storage::disk(StoresImageUploads::disk())->url($this->hero_image_path);
        }

        return $this->hero_image_url;
    }

    protected function formattedDate(): Attribute
    {
        return Attribute::get(
            fn (): ?string => $this->published_at?->format('M d, Y')
        );
    }

    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title) ?: 'post';
        $slug = $baseSlug;
        $counter = 2;

        while (
            static::query()
                ->when($ignoreId, fn (Builder $query) => $query->whereKeyNot($ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
