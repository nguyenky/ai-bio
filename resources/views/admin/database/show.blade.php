@extends('layouts.admin')

@section('title', 'Database | '.config('app.name'))

@section('content')
    <div class="admin-header">
        <div>
            <p class="eyebrow">Database</p>
            <h1 class="display-6 mb-2">SQLite storage and content overview.</h1>
            <p class="text-secondary mb-0">Your admin forms already manage data inside this database file. This page helps you verify the file path and repair it if the file is missing on deploy.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="admin-stat card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-uppercase small text-secondary mb-2">Connection</p>
                    <h2 class="h4 mb-0">{{ $connection }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-stat card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-uppercase small text-secondary mb-2">Driver</p>
                    <h2 class="h4 mb-0">{{ $driver }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-stat card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-uppercase small text-secondary mb-2">File status</p>
                    <h2 class="h4 mb-0">{{ $databaseExists ? 'Ready' : 'Missing' }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h2 class="h4 mb-3">SQLite file</h2>
                    <p class="text-secondary mb-2">Path</p>
                    <p class="small mb-4" style="word-break: break-all;">{{ $databasePath ?? 'Not available for the current connection.' }}</p>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-4">
                            <div class="border rounded-4 p-3 h-100 bg-light-subtle">
                                <p class="text-uppercase small text-secondary mb-2">Posts</p>
                                <p class="fs-4 fw-semibold mb-0">{{ $postCount }}</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="border rounded-4 p-3 h-100 bg-light-subtle">
                                <p class="text-uppercase small text-secondary mb-2">Instagram items</p>
                                <p class="fs-4 fw-semibold mb-0">{{ $instagramCount }}</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="border rounded-4 p-3 h-100 bg-light-subtle">
                                <p class="text-uppercase small text-secondary mb-2">Admin users</p>
                                <p class="fs-4 fw-semibold mb-0">{{ $userCount }}</p>
                            </div>
                        </div>
                    </div>

                    <p class="text-secondary mb-2">File size</p>
                    <p class="mb-4">{{ $databaseSize ? number_format($databaseSize / 1024, 2) . ' KB' : 'Not available yet' }}</p>

                    <form method="POST" action="{{ route('admin.database.initialize') }}">
                        @csrf
                        <button class="btn btn-dark rounded-pill px-4" type="submit">Create or repair SQLite file</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h4 mb-3">Manage content</h2>
                    <p class="text-secondary mb-4">These sections already save directly into SQLite. Use them to manage the actual data shown on the website.</p>
                    <div class="d-grid gap-2">
                        <a class="btn btn-outline-dark rounded-pill px-4" href="{{ route('admin.posts.index') }}">Manage posts</a>
                        <a class="btn btn-outline-dark rounded-pill px-4" href="{{ route('admin.instagram-items.index') }}">Manage Instagram items</a>
                        <a class="btn btn-outline-dark rounded-pill px-4" href="{{ route('admin.settings.edit') }}">Manage site settings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
