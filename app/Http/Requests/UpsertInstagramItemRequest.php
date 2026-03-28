<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpsertInstagramItemRequest extends FormRequest
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
            'title' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:500'],
            'image_upload' => ['nullable', 'image', 'max:4096'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'instagram_url' => ['required', 'url', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
            'remove_image' => ['nullable', 'boolean'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $item = $this->route('instagram_item');
            $hasExistingImage = filled($item?->image_path) || filled($item?->image_url);
            $hasIncomingImage = $this->hasFile('image_upload') || filled($this->string('image_url'));
            $isRemovingOnly = $this->boolean('remove_image') && ! $hasIncomingImage;

            if ((! $hasExistingImage && ! $hasIncomingImage) || $isRemovingOnly) {
                $validator->errors()->add('image_upload', 'Add an uploaded image or an external image URL.');
            }
        });
    }
}
