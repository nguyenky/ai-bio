@extends('layouts.admin')

@section('title', 'Create Post | '.config('app.name'))

@section('content')
    <div class="admin-header">
        <p class="eyebrow">Posts</p>
        <h1 class="display-6 mb-2">Create a new post</h1>
        <p class="text-secondary mb-0">Add a fresh note, image, or article for the homepage and journal.</p>
    </div>

    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.posts._form', ['submitLabel' => 'Create post'])
    </form>
@endsection
