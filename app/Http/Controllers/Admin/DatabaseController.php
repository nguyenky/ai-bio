<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstagramItem;
use App\Models\Post;
use App\Models\User;
use App\Support\SqliteDatabaseManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DatabaseController extends Controller
{
    public function show(): View
    {
        $path = SqliteDatabaseManager::path();
        $sizeInBytes = SqliteDatabaseManager::sizeInBytes();

        return view('admin.database.show', [
            'connection' => config('database.default'),
            'driver' => config('database.connections.'.config('database.default').'.driver'),
            'databasePath' => $path,
            'databaseExists' => SqliteDatabaseManager::exists(),
            'databaseSize' => $sizeInBytes,
            'postCount' => Post::count(),
            'instagramCount' => InstagramItem::count(),
            'userCount' => User::count(),
        ]);
    }

    public function initialize(): RedirectResponse
    {
        if (! SqliteDatabaseManager::usesSqlite()) {
            return back()->withErrors([
                'database' => 'The current app environment is not using SQLite.',
            ]);
        }

        $path = SqliteDatabaseManager::ensureExists();

        return redirect()
            ->route('admin.database.show')
            ->with('status', "SQLite database ready at {$path}");
    }
}
