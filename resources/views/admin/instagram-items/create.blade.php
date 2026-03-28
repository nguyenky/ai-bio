@extends('layouts.admin')

@section('title', 'Create Instagram Item | '.config('app.name'))

@section('content')
    <div class="admin-header">
        <p class="eyebrow">Instagram items</p>
        <h1 class="display-6 mb-2">Add an Instagram highlight</h1>
        <p class="text-secondary mb-0">Choose the image and link you want to surface on the homepage.</p>
    </div>

    <form method="POST" action="{{ route('admin.instagram-items.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.instagram-items._form', ['submitLabel' => 'Create item'])
    </form>
@endsection
