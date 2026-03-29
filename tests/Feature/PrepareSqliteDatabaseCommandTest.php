<?php

namespace Tests\Feature;

use App\Support\SqliteDatabaseManager;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class PrepareSqliteDatabaseCommandTest extends TestCase
{
    public function test_it_creates_the_sqlite_file_when_missing(): void
    {
        $path = storage_path('framework/testing/sqlite/prepare-command.sqlite');

        File::delete($path);
        File::ensureDirectoryExists(dirname($path));

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => $path,
        ]);

        $this->artisan('app:prepare-sqlite')
            ->expectsOutput("SQLite database ready: {$path}")
            ->assertExitCode(0);

        $this->assertTrue(File::exists($path));

        File::delete($path);
    }

    public function test_it_rejects_non_sqlite_connections(): void
    {
        config([
            'database.default' => 'mysql',
            'database.connections.mysql.driver' => 'mysql',
        ]);

        $this->artisan('app:prepare-sqlite')
            ->expectsOutput('The default database connection is not sqlite.')
            ->assertExitCode(1);
    }
}
