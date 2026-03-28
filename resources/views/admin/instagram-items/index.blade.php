@extends('layouts.admin')

@section('title', 'Instagram Items | '.config('app.name'))

@section('content')
    <div class="admin-header d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3">
        <div>
            <p class="eyebrow">Instagram items</p>
            <h1 class="display-6 mb-2">Curate the homepage grid</h1>
            <p class="text-secondary mb-0">Paste Instagram links in bulk or create fully custom items one by one.</p>
        </div>
        <a class="btn btn-dark rounded-pill px-4" href="{{ route('admin.instagram-items.create') }}">Add item</a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row g-4 align-items-end">
                <div class="col-lg-8">
                    <h2 class="h4 mb-2">Quick import by link</h2>
                    <p class="text-secondary mb-0">Paste one Instagram post, reel, or TV URL per line. The app will try to read the public page and save the image, title, and description automatically, then link the card to the original post.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <span class="badge text-bg-light">Experimental fetch</span>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.instagram-items.import') }}" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="links">Instagram links</label>
                    <textarea class="form-control" id="links" name="links" rows="5" placeholder="https://www.instagram.com/p/ABC123/&#10;https://www.instagram.com/reel/XYZ789/">{{ old('links') }}</textarea>
                </div>
                <button class="btn btn-dark rounded-pill px-4" type="submit">Import links</button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        @forelse ($items as $item)
            <div class="col-md-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100">
                    @if ($item->imageUrl())
                        <img src="{{ $item->imageUrl() }}" alt="{{ $item->title ?: 'Instagram item' }}" class="admin-grid-image">
                    @else
                        <div class="admin-grid-image placeholder-glow"><span class="placeholder col-8"></span></div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between gap-2 mb-2">
                            <h2 class="h5 mb-0">{{ $item->title ?: 'Instagram moment' }}</h2>
                            @if ($item->is_visible)
                                <span class="badge text-bg-dark">Visible</span>
                            @else
                                <span class="badge text-bg-secondary">Hidden</span>
                            @endif
                        </div>
                        <p class="text-secondary small mb-3">{{ $item->caption ?: 'No caption added yet.' }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-secondary">Sort: {{ $item->sort_order }}</small>
                            <div class="d-flex gap-2">
                                <a class="btn btn-sm btn-outline-dark rounded-pill px-3" href="{{ route('admin.instagram-items.edit', $item) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.instagram-items.destroy', $item) }}" onsubmit="return confirm('Delete this Instagram item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3" type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-panel">No Instagram items yet. Add a few to fill the homepage gallery.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $items->links() }}
    </div>
@endsection
