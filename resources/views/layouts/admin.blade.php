<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin | '.config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="admin-body">
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a class="admin-brand" href="{{ route('admin.dashboard') }}">{{ config('app.name') }}</a>
            <p class="admin-sidebar-copy">Manage homepage content, blog posts, and Instagram items.</p>

            <nav class="nav flex-column gap-2 mt-4">
                <a class="admin-nav-link @if (request()->routeIs('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="admin-nav-link @if (request()->routeIs('admin.posts.*')) active @endif" href="{{ route('admin.posts.index') }}">Posts</a>
                <a class="admin-nav-link @if (request()->routeIs('admin.instagram-items.*')) active @endif" href="{{ route('admin.instagram-items.index') }}">Instagram Items</a>
                <a class="admin-nav-link @if (request()->routeIs('admin.database.*')) active @endif" href="{{ route('admin.database.show') }}">Database</a>
                <a class="admin-nav-link @if (request()->routeIs('admin.settings.*')) active @endif" href="{{ route('admin.settings.edit') }}">Settings</a>
                <a class="admin-nav-link" href="{{ route('home') }}" target="_blank" rel="noreferrer">View Site</a>
            </nav>

            <form class="mt-auto pt-4" method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="btn btn-dark w-100 rounded-pill" type="submit">Sign Out</button>
            </form>
        </aside>

        <main class="admin-main">
            @include('partials.flash')
            @yield('content')
        </main>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.0/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
