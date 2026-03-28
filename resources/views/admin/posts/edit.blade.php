@extends('layouts.admin')

@section('title', 'Edit Post | '.config('app.name'))

@section('content')
    <div class="admin-header">
        <p class="eyebrow">Posts</p>
        <h1 class="display-6 mb-2">Edit post</h1>
        <p class="text-secondary mb-0">Update copy, imagery, or homepage placement for this article.</p>
    </div>

    <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.posts._form', ['submitLabel' => 'Save changes'])
    </form>
@endsection
