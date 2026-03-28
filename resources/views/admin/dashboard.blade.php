@extends('layouts.admin')

@section('title', 'Dashboard | '.config('app.name'))

@section('content')
    <div class="admin-header">
        <div>
            <p class="eyebrow">Dashboard</p>
            <h1 class="display-6 mb-2">Keep your homepage fresh.</h1>
            <p class="text-secondary mb-0">Update the intro, publish posts, and curate Instagram highlights from one place.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="admin-stat card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-uppercase small text-secondary mb-2">All posts</p>
                    <h2 class="display-6 mb-0">{{ $postCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-stat card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-uppercase small text-secondary mb-2">Published</p>
                    <h2 class="display-6 mb-0">{{ $publishedPostCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-stat card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-uppercase small text-secondary mb-2">Instagram items</p>
                    <h2 class="display-6 mb-0">{{ $instagramCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h4 mb-0">Recent post activity</h2>
                        <a class="btn btn-sm btn-dark rounded-pill px-3" href="{{ route('admin.posts.create') }}">New post</a>
                    </div>

                    @if ($recentPosts->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Updated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentPosts as $post)
                                        <tr>
                                            <td>
                                                <a class="fw-semibold text-decoration-none" href="{{ route('admin.posts.edit', $post) }}">{{ $post->title }}</a>
                                            </td>
                                            <td>
                                                @if ($post->published_at)
                                                    <span class="badge text-bg-dark">Published</span>
                                                @else
                                                    <span class="badge text-bg-secondary">Draft</span>
                                                @endif
                                            </td>
                                            <td>{{ $post->updated_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-panel">No posts yet. Start by adding your first article.</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h2 class="h4 mb-3">Homepage snapshot</h2>
                    <p class="text-secondary mb-2">Current hero heading</p>
                    <p class="fw-semibold fs-5">{{ $settings->hero_heading }}</p>
                    <p class="text-secondary mb-2 mt-4">Short bio</p>
                    <p class="mb-4">{{ $settings->short_bio }}</p>
                    <a class="btn btn-outline-dark rounded-pill px-4" href="{{ route('admin.settings.edit') }}">Edit homepage settings</a>
                </div>
            </div>
        </div>
    </div>
@endsection
