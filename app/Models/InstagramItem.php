<?php

namespace App\Models;

use App\Support\StoresImageUploads;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class InstagramItem extends Model
{
    protected $fillable = [
        'title',
        'caption',
        'image_path',
        'image_url',
        'instagram_url',
        'sort_order',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
        ];
    }

    public function imageUrl(): ?string
    {
        if ($this->image_path) {
            return Storage::disk(StoresImageUploads::disk())->url($this->image_path);
        }

        return $this->image_url;
    }
}
