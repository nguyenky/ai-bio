<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="mb-3">
                    <label class="form-label" for="title">Title</label>
                    <input class="form-control" id="title" name="title" type="text" value="{{ old('title', $post->title) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="excerpt">Excerpt</label>
                    <textarea class="form-control" id="excerpt" name="excerpt" rows="3" required>{{ old('excerpt', $post->excerpt) }}</textarea>
                </div>
                <div>
                    <label class="form-label" for="body">Body</label>
                    <textarea class="form-control" id="body" name="body" rows="12" required>{{ old('body', $post->body) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h2 class="h5 mb-3">Publishing</h2>
                <div class="form-check mb-3">
                    <input class="form-check-input" id="is_published" name="is_published" type="checkbox" value="1" @checked(old('is_published', $post->published_at !== null))>
                    <label class="form-check-label" for="is_published">Publish immediately</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" id="is_featured" name="is_featured" type="checkbox" value="1" @checked(old('is_featured', $post->is_featured))>
                    <label class="form-check-label" for="is_featured">Feature on homepage</label>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h2 class="h5 mb-3">Hero image</h2>

                @if ($post->heroImageUrl())
                    <img src="{{ $post->heroImageUrl() }}" alt="{{ $post->title }}" class="admin-preview-image mb-3">
                @endif

                <div class="mb-3">
                    <label class="form-label" for="hero_image_upload">Upload image</label>
                    <input class="form-control" id="hero_image_upload" name="hero_image_upload" type="file" accept="image/*">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="hero_image_url">External image URL</label>
                    <input class="form-control" id="hero_image_url" name="hero_image_url" type="url" value="{{ old('hero_image_url', $post->hero_image_url) }}">
                </div>
                <div class="form-check">
                    <input class="form-check-input" id="remove_hero_image" name="remove_hero_image" type="checkbox" value="1">
                    <label class="form-check-label" for="remove_hero_image">Remove uploaded image</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end gap-3 mt-4">
    <a class="btn btn-outline-dark rounded-pill px-4" href="{{ route('admin.posts.index') }}">Cancel</a>
    <button class="btn btn-dark rounded-pill px-4" type="submit">{{ $submitLabel }}</button>
</div>
