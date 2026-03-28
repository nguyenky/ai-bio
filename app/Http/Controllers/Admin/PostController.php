<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpsertPostRequest;
use App\Models\Post;
use App\Support\StoresImageUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        return view('admin.posts.index', [
            'posts' => Post::query()
                ->latest('published_at')
                ->latest('updated_at')
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.create', [
            'post' => new Post(),
        ]);
    }

    public function store(UpsertPostRequest $request): RedirectResponse
    {
        $post = new Post();
        $this->persistPost($request, $post);

        return redirect()->route('admin.posts.index')
            ->with('status', 'Post created successfully.');
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.edit', [
            'post' => $post,
        ]);
    }

    public function update(UpsertPostRequest $request, Post $post): RedirectResponse
    {
        $this->persistPost($request, $post);

        return redirect()->route('admin.posts.index')
            ->with('status', 'Post updated successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->hero_image_path) {
            StoresImageUploads::sync(request(), 'hero_image_upload', $post->hero_image_path, 'posts', true);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('status', 'Post deleted successfully.');
    }

    protected function persistPost(UpsertPostRequest $request, Post $post): void
    {
        $validated = $request->validated();

        $post->fill([
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'],
            'body' => $validated['body'],
            'hero_image_url' => $validated['hero_image_url'] ?: null,
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $request->boolean('is_published')
                ? ($post->published_at ?? now())
                : null,
        ]);

        $post->hero_image_path = StoresImageUploads::sync(
            $request,
            'hero_image_upload',
            $post->hero_image_path,
            'posts',
            $request->boolean('remove_hero_image')
        );

        $post->save();
    }
}
