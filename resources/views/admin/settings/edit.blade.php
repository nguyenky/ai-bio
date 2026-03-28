@extends('layouts.admin')

@section('title', 'Settings | '.config('app.name'))

@section('content')
    <div class="admin-header">
        <p class="eyebrow">Settings</p>
        <h1 class="display-6 mb-2">Shape the homepage story</h1>
        <p class="text-secondary mb-0">Update your intro, profile image, social links, and basic SEO details.</p>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label" for="hero_heading">Hero heading</label>
                            <input class="form-control" id="hero_heading" name="hero_heading" type="text" value="{{ old('hero_heading', $settings->hero_heading) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="short_bio">Short bio</label>
                            <input class="form-control" id="short_bio" name="short_bio" type="text" value="{{ old('short_bio', $settings->short_bio) }}" required>
                        </div>
                        <div class="mb-0">
                            <label class="form-label" for="intro_text">Intro text</label>
                            <textarea class="form-control" id="intro_text" name="intro_text" rows="8" required>{{ old('intro_text', $settings->intro_text) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h2 class="h5 mb-3">Profile image</h2>

                        @if ($settings->profileImageUrl())
                            <img src="{{ $settings->profileImageUrl() }}" alt="Profile image" class="admin-preview-image mb-3">
                        @endif

                        <div class="mb-3">
                            <label class="form-label" for="profile_image_upload">Upload image</label>
                            <input class="form-control" id="profile_image_upload" name="profile_image_upload" type="file" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="profile_image_url">External image URL</label>
                            <input class="form-control" id="profile_image_url" name="profile_image_url" type="url" value="{{ old('profile_image_url', $settings->profile_image_url) }}">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="remove_profile_image" name="remove_profile_image" type="checkbox" value="1">
                            <label class="form-check-label" for="remove_profile_image">Remove uploaded image</label>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h5 mb-3">Social links</h2>
                        <div class="mb-3">
                            <label class="form-label" for="instagram_profile_url">Instagram profile</label>
                            <input class="form-control" id="instagram_profile_url" name="instagram_profile_url" type="url" value="{{ old('instagram_profile_url', $settings->instagram_profile_url) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="linkedin_url">LinkedIn</label>
                            <input class="form-control" id="linkedin_url" name="linkedin_url" type="url" value="{{ old('linkedin_url', $settings->linkedin_url) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="github_url">GitHub</label>
                            <input class="form-control" id="github_url" name="github_url" type="url" value="{{ old('github_url', $settings->github_url) }}">
                        </div>
                        <div>
                            <label class="form-label" for="x_url">X</label>
                            <input class="form-control" id="x_url" name="x_url" type="url" value="{{ old('x_url', $settings->x_url) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body p-4">
                <h2 class="h5 mb-3">SEO</h2>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="seo_title">SEO title</label>
                        <input class="form-control" id="seo_title" name="seo_title" type="text" value="{{ old('seo_title', $settings->seo_title) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="seo_description">SEO description</label>
                        <input class="form-control" id="seo_description" name="seo_description" type="text" value="{{ old('seo_description', $settings->seo_description) }}" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-3 mt-4">
            <a class="btn btn-outline-dark rounded-pill px-4" href="{{ route('admin.dashboard') }}">Cancel</a>
            <button class="btn btn-dark rounded-pill px-4" type="submit">Save settings</button>
        </div>
    </form>
@endsection
