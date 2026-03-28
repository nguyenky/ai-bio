<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoresImageUploads
{
    public static function disk(): string
    {
        return (string) config('filesystems.uploads', 'public');
    }

    public static function sync(
        Request $request,
        string $field,
        ?string $currentPath,
        string $directory,
        bool $removeExisting = false
    ): ?string {
        if ($removeExisting && $currentPath) {
            Storage::disk(static::disk())->delete($currentPath);
            $currentPath = null;
        }

        if (! $request->hasFile($field)) {
            return $currentPath;
        }

        if ($currentPath) {
            Storage::disk(static::disk())->delete($currentPath);
        }

        return $request->file($field)->store($directory, static::disk());
    }
}
