<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', $settings->seo_description ?? config('app.name'))">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('head')
</head>
<body>
    <div class="site-shell">
        <header class="site-header">
            <nav class="navbar navbar-expand-lg py-3">
                <div class="container">
                    <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
                    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#siteNav" aria-controls="siteNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="siteNav">
                        <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('posts.index') }}">Journal</a></li>
                            @if (! empty($settings?->instagram_profile_url))
                                <li class="nav-item"><a class="nav-link" href="{{ $settings->instagram_profile_url }}" target="_blank" rel="noreferrer">Instagram</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            @include('partials.flash')
            @yield('content')
        </main>

        <footer class="site-footer">
            <div class="container d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-center">
                <div>
                    <p class="mb-1 footer-label">{{ config('app.name') }}</p>
                    <p class="mb-0 footer-copy">Personal notes, blog posts, and curated visual moments.</p>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    @if (! empty($settings?->instagram_profile_url))
                        <a href="{{ $settings->instagram_profile_url }}" target="_blank" rel="noreferrer">Instagram</a>
                    @endif
                    @if (! empty($settings?->linkedin_url))
                        <a href="{{ $settings->linkedin_url }}" target="_blank" rel="noreferrer">LinkedIn</a>
                    @endif
                    @if (! empty($settings?->github_url))
                        <a href="{{ $settings->github_url }}" target="_blank" rel="noreferrer">GitHub</a>
                    @endif
                    @if (! empty($settings?->x_url))
                        <a href="{{ $settings->x_url }}" target="_blank" rel="noreferrer">X</a>
                    @endif
                </div>
            </div>
        </footer>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.0/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
