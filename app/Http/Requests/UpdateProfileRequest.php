<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'avatar' => 'sometimes|string|nullable',
            'bio' => 'sometimes|string|nullable|max:500',
            'location' => 'sometimes|string|nullable|max:255',
            'birth_date' => 'sometimes|date|nullable',
            'phone' => 'sometimes|string|nullable|max:20',
            'website' => 'sometimes|url|nullable|max:255',
            'social_links' => 'sometimes|array|nullable',
            'social_links.*' => 'url',
            'theme_preference' => 'sometimes|string|in:light,dark',
            'language_preference' => 'sometimes|string|in:es,en'
        ];
    }
}
