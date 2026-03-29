<?php

namespace App\Console\Commands;

use App\Support\SqliteDatabaseManager;
use Illuminate\Console\Command;

class PrepareSqliteDatabase extends Command
{
    protected $signature = 'app:prepare-sqlite';

    protected $description = 'Ensure the configured SQLite database file exists';

    public function handle(): int
    {
        if (! SqliteDatabaseManager::usesSqlite()) {
            $this->line('The default database connection is not sqlite.');

            return self::FAILURE;
        }

        $path = SqliteDatabaseManager::ensureExists();

        $this->line("SQLite database ready: {$path}");

        return self::SUCCESS;
    }
}
