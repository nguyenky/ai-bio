@extends('layouts.app')

@section('title', 'Journal | '.$settings->seo_title)
@section('meta_description', $settings->seo_description)

@section('content')
    <section class="page-hero">
        <div class="container">
            <p class="eyebrow">Journal</p>
            <h1 class="display-4 mb-3">Personal news, notes, and longer stories.</h1>
            <p class="lead text-secondary mb-0">A running collection of updates from the blog.</p>
        </div>
    </section>

    <section class="section-space pt-0">
        <div class="container">
            <div class="row g-4">
                @forelse ($posts as $post)
                    <div class="col-md-6 col-xl-4">
                        @include('partials.post-card', ['post' => $post])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-panel">No posts are published yet.</div>
                    </div>
                @endforelse
            </div>

            <div class="mt-5">
                {{ $posts->links() }}
            </div>
        </div>
    </section>
@endsection
