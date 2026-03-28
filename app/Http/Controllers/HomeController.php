<?php

namespace App\Http\Controllers;

use App\Models\InstagramItem;
use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $settings = SiteSetting::current();

        $featuredPost = Post::published()
            ->where('is_featured', true)
            ->latest('published_at')
            ->first();

        $featuredPost ??= Post::published()
            ->latest('published_at')
            ->first();

        $recentPosts = Post::published()
            ->when($featuredPost, fn ($query) => $query->whereKeyNot($featuredPost->id))
            ->latest('published_at')
            ->take(3)
            ->get();

        $instagramItems = InstagramItem::query()
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->latest('updated_at')
            ->take(6)
            ->get();

        return view('home', [
            'settings' => $settings,
            'featuredPost' => $featuredPost,
            'recentPosts' => $recentPosts,
            'instagramItems' => $instagramItems,
        ]);
    }
}
