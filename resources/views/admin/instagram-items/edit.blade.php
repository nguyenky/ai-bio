@extends('layouts.admin')

@section('title', 'Edit Instagram Item | '.config('app.name'))

@section('content')
    <div class="admin-header">
        <p class="eyebrow">Instagram items</p>
        <h1 class="display-6 mb-2">Edit Instagram highlight</h1>
        <p class="text-secondary mb-0">Adjust the image, caption, sort order, or visibility for this item.</p>
    </div>

    <form method="POST" action="{{ route('admin.instagram-items.update', $item) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.instagram-items._form', ['submitLabel' => 'Save changes'])
    </form>
@endsection
