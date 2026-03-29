<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class SqliteDatabaseManager
{
    public static function usesSqlite(?string $connectionName = null): bool
    {
        $connectionName ??= config('database.default');

        return config("database.connections.{$connectionName}.driver") === 'sqlite';
    }

    public static function path(?string $connectionName = null): ?string
    {
        if (! static::usesSqlite($connectionName)) {
            return null;
        }

        $connectionName ??= config('database.default');
        $path = (string) config("database.connections.{$connectionName}.database");

        if ($path === '' || $path === ':memory:') {
            return null;
        }

        if (! static::isAbsolutePath($path)) {
            $path = base_path($path);
            config(["database.connections.{$connectionName}.database" => $path]);
        }

        return $path;
    }

    public static function exists(?string $connectionName = null): bool
    {
        $path = static::path($connectionName);

        return $path !== null && File::exists($path);
    }

    public static function ensureExists(?string $connectionName = null): ?string
    {
        $path = static::path($connectionName);

        if ($path === null) {
            return null;
        }

        File::ensureDirectoryExists(dirname($path));

        if (! File::exists($path)) {
            File::put($path, '');
        }

        return $path;
    }

    public static function sizeInBytes(?string $connectionName = null): ?int
    {
        $path = static::path($connectionName);

        if ($path === null || ! File::exists($path)) {
            return null;
        }

        return File::size($path);
    }

    protected static function isAbsolutePath(string $path): bool
    {
        return str_starts_with($path, DIRECTORY_SEPARATOR)
            || (bool) preg_match('/^[A-Za-z]:[\\\\\\/]/', $path);
    }
}
