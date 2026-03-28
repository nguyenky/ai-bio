<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="mb-3">
                    <label class="form-label" for="title">Title</label>
                    <input class="form-control" id="title" name="title" type="text" value="{{ old('title', $item->title) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="caption">Caption</label>
                    <textarea class="form-control" id="caption" name="caption" rows="4">{{ old('caption', $item->caption) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="instagram_url">Instagram link</label>
                    <input class="form-control" id="instagram_url" name="instagram_url" type="url" value="{{ old('instagram_url', $item->instagram_url) }}" required>
                </div>
                <div>
                    <label class="form-label" for="sort_order">Sort order</label>
                    <input class="form-control" id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $item->sort_order ?? 0) }}">
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h2 class="h5 mb-3">Visual</h2>

                @if ($item->imageUrl())
                    <img src="{{ $item->imageUrl() }}" alt="{{ $item->title ?: 'Instagram item' }}" class="admin-preview-image mb-3">
                @endif

                <div class="mb-3">
                    <label class="form-label" for="image_upload">Upload image</label>
                    <input class="form-control" id="image_upload" name="image_upload" type="file" accept="image/*">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="image_url">External image URL</label>
                    <input class="form-control" id="image_url" name="image_url" type="url" value="{{ old('image_url', $item->image_url) }}">
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" id="remove_image" name="remove_image" type="checkbox" value="1">
                    <label class="form-check-label" for="remove_image">Remove uploaded image</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" id="is_visible" name="is_visible" type="checkbox" value="1" @checked(old('is_visible', $item->is_visible ?? true))>
                    <label class="form-check-label" for="is_visible">Show on homepage</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end gap-3 mt-4">
    <a class="btn btn-outline-dark rounded-pill px-4" href="{{ route('admin.instagram-items.index') }}">Cancel</a>
    <button class="btn btn-dark rounded-pill px-4" type="submit">{{ $submitLabel }}</button>
</div>
