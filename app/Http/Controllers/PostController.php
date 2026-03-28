<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Post::published()
            ->latest('published_at')
            ->paginate(9);

        return view('posts.index', [
            'posts' => $posts,
            'settings' => SiteSetting::current(),
        ]);
    }

    public function show(string $slug): View
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedPosts = Post::published()
            ->whereKeyNot($post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('posts.show', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'settings' => SiteSetting::current(),
        ]);
    }
}
