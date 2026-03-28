<article class="post-card card border-0 shadow-sm h-100">
    @if ($post->heroImageUrl())
        <img src="{{ $post->heroImageUrl() }}" alt="{{ $post->title }}" class="card-img-top post-card-image">
    @else
        <div class="post-card-placeholder"></div>
    @endif
    <div class="card-body d-flex flex-column p-4">
        <p class="post-meta mb-2">{{ $post->formatted_date }}</p>
        <h3 class="h4 post-card-title">{{ $post->title }}</h3>
        <p class="text-secondary flex-grow-1 mb-4">{{ $post->excerpt }}</p>
        <a href="{{ route('posts.show', $post->slug) }}" class="post-link">Read article</a>
    </div>
</article>
