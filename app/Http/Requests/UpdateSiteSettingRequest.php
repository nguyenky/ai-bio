<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hero_heading' => ['required', 'string', 'max:255'],
            'short_bio' => ['required', 'string', 'max:255'],
            'intro_text' => ['required', 'string'],
            'profile_image_upload' => ['nullable', 'image', 'max:4096'],
            'profile_image_url' => ['nullable', 'url', 'max:2048'],
            'remove_profile_image' => ['nullable', 'boolean'],
            'instagram_profile_url' => ['nullable', 'url', 'max:2048'],
            'linkedin_url' => ['nullable', 'url', 'max:2048'],
            'github_url' => ['nullable', 'url', 'max:2048'],
            'x_url' => ['nullable', 'url', 'max:2048'],
            'seo_title' => ['required', 'string', 'max:255'],
            'seo_description' => ['required', 'string', 'max:255'],
        ];
    }
}
