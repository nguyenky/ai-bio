<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstagramItem;
use App\Models\Post;
use App\Models\SiteSetting;
use App\Support\SqliteDatabaseManager;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('admin.dashboard', [
            'postCount' => Post::count(),
            'publishedPostCount' => Post::published()->count(),
            'instagramCount' => InstagramItem::count(),
            'settings' => SiteSetting::current(),
            'recentPosts' => Post::latest('updated_at')->take(5)->get(),
            'databaseDriver' => config('database.connections.'.config('database.default').'.driver'),
            'databasePath' => SqliteDatabaseManager::path(),
            'databaseExists' => SqliteDatabaseManager::exists(),
        ]);
    }
}
