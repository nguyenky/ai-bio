@extends('layouts.app')

@section('title', $post->title.' | '.$settings->seo_title)
@section('meta_description', $post->excerpt)

@section('content')
    <article class="post-detail">
        <section class="page-hero pb-4">
            <div class="container">
                <a class="section-link d-inline-block mb-4" href="{{ route('posts.index') }}">Back to journal</a>
                <p class="eyebrow">{{ $post->formatted_date }}</p>
                <h1 class="display-3 post-detail-title">{{ $post->title }}</h1>
                <p class="lead text-secondary post-detail-excerpt">{{ $post->excerpt }}</p>
            </div>
        </section>

        @if ($post->heroImageUrl())
            <section class="pb-5">
                <div class="container">
                    <img src="{{ $post->heroImageUrl() }}" alt="{{ $post->title }}" class="post-hero-image">
                </div>
            </section>
        @endif

        <section class="pb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-9 col-xl-8">
                        <div class="article-body">{!! nl2br(e($post->body)) !!}</div>
                    </div>
                </div>
            </div>
        </section>
    </article>

    @if ($relatedPosts->isNotEmpty())
        <section class="section-space pt-0">
            <div class="container">
                <div class="section-heading">
                    <p class="eyebrow">Continue reading</p>
                    <h2>More from the journal</h2>
                </div>

                <div class="row g-4">
                    @foreach ($relatedPosts as $relatedPost)
                        <div class="col-md-6 col-xl-4">
                            @include('partials.post-card', ['post' => $relatedPost])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
