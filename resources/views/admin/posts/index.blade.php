@extends('layouts.admin')

@section('title', 'Posts | '.config('app.name'))

@section('content')
    <div class="admin-header d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3">
        <div>
            <p class="eyebrow">Posts</p>
            <h1 class="display-6 mb-2">Manage the journal</h1>
            <p class="text-secondary mb-0">Create, edit, publish, and feature personal news or long-form articles.</p>
        </div>
        <a class="btn btn-dark rounded-pill px-4" href="{{ route('admin.posts.create') }}">Create post</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if ($posts->isNotEmpty())
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Title</th>
                                <th>Featured</th>
                                <th>Status</th>
                                <th>Published</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-semibold">{{ $post->title }}</div>
                                        <div class="small text-secondary">{{ $post->excerpt }}</div>
                                    </td>
                                    <td>
                                        @if ($post->is_featured)
                                            <span class="badge text-bg-warning">Featured</span>
                                        @else
                                            <span class="badge text-bg-light">Standard</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($post->published_at)
                                            <span class="badge text-bg-dark">Published</span>
                                        @else
                                            <span class="badge text-bg-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>{{ $post->published_at?->format('M d, Y') ?? 'Not published' }}</td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a class="btn btn-sm btn-outline-dark rounded-pill px-3" href="{{ route('admin.posts.edit', $post) }}">Edit</a>
                                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Delete this post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger rounded-pill px-3" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-4">
                    <div class="empty-panel">No posts yet. Create one to populate the homepage and journal.</div>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
@endsection
