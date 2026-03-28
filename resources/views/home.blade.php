@extends('layouts.app')

@section('title', $settings->seo_title)
@section('meta_description', $settings->seo_description)

@section('content')
    <section class="hero-section">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <p class="eyebrow">Personal journal</p>
                    <h1 class="display-2 hero-title">{{ $settings->hero_heading }}</h1>
                    <p class="lead hero-copy">{{ $settings->short_bio }}</p>
                    <div class="hero-text">{!! nl2br(e($settings->intro_text)) !!}</div>
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a class="btn btn-dark rounded-pill px-4" href="{{ route('posts.index') }}">Browse posts</a>
                        @if ($settings->instagram_profile_url)
                            <a class="btn btn-outline-dark rounded-pill px-4" href="{{ $settings->instagram_profile_url }}" target="_blank" rel="noreferrer">Visit Instagram</a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="profile-panel">
                        @if ($settings->profileImageUrl())
                            <img src="{{ $settings->profileImageUrl() }}" alt="Profile image" class="profile-image">
                        @else
                            <div class="profile-image placeholder-glow d-flex align-items-end">
                                <span class="placeholder col-8"></span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($featuredPost)
        <section class="section-space">
            <div class="container">
                <div class="section-heading">
                    <p class="eyebrow">Featured note</p>
                    <h2>Latest spotlight from the journal</h2>
                </div>

                <article class="featured-post card border-0 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            @if ($featuredPost->heroImageUrl())
                                <img src="{{ $featuredPost->heroImageUrl() }}" alt="{{ $featuredPost->title }}" class="featured-post-image">
                            @else
                                <div class="featured-post-image featured-placeholder"></div>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <div class="featured-post-body">
                                <p class="post-meta mb-3">{{ $featuredPost->formatted_date }}</p>
                                <h3 class="display-6 mb-3">{{ $featuredPost->title }}</h3>
                                <p class="text-secondary mb-4">{{ $featuredPost->excerpt }}</p>
                                <a class="btn btn-dark rounded-pill px-4" href="{{ route('posts.show', $featuredPost->slug) }}">Read featured post</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>
    @endif

    <section class="section-space">
        <div class="container">
            <div class="section-heading d-flex justify-content-between align-items-end gap-3">
                <div>
                    <p class="eyebrow">Recent writing</p>
                    <h2>Fresh stories and updates</h2>
                </div>
                <a href="{{ route('posts.index') }}" class="section-link">See all posts</a>
            </div>

            <div class="row g-4">
                @forelse ($recentPosts as $post)
                    <div class="col-md-6 col-xl-4">
                        @include('partials.post-card', ['post' => $post])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-panel">No published posts yet. Sign in to the admin area to add your first update.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section-space instagram-section">
        <div class="container">
            <div class="section-heading d-flex justify-content-between align-items-end gap-3">
                <div>
                    <p class="eyebrow">Instagram picks</p>
                    <h2>Curated moments from the feed</h2>
                </div>
                @if ($settings->instagram_profile_url)
                    <a href="{{ $settings->instagram_profile_url }}" class="section-link" target="_blank" rel="noreferrer">Open profile</a>
                @endif
            </div>

            <div class="instagram-grid">
                @forelse ($instagramItems as $item)
                    <a href="{{ $item->instagram_url }}" target="_blank" rel="noreferrer" class="instagram-card">
                        @if ($item->imageUrl())
                            <img src="{{ $item->imageUrl() }}" alt="{{ $item->title ?: 'Instagram item' }}">
                        @else
                            <div class="instagram-placeholder"></div>
                        @endif
                        <div class="instagram-overlay">
                            <p class="mb-1 fw-semibold">{{ $item->title ?: 'Open on Instagram' }}</p>
                            @if ($item->caption)
                                <p class="mb-0 small opacity-75">{{ $item->caption }}</p>
                            @else
                                <p class="mb-0 small opacity-75">Tap to view the original post on Instagram.</p>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="empty-panel">Instagram highlights will appear here after you add them in the admin area.</div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
