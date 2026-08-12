<?php

namespace App\Http\Requests;

use App\Models\Game;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * UpdateGameRequest
 *
 * Validates incoming data when updating an existing game.
 * Uses the same rules as StoreGameRequest but is kept as a separate class
 * for clarity — each form has its own dedicated Form Request.
 */
class UpdateGameRequest extends FormRequest
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
            'title'        => 'required|string|max:255',
            'genre'        => ['required', 'string', 'max:100'],
            'platform'     => ['required', 'string', 'max:100'],
            'developer'    => 'required|string|max:255',
            'release_date' => 'required|date',
            'status'       => ['required', Rule::in(Game::STATUS_OPTIONS)],
            'price'        => 'nullable|numeric|min:0',
            'description'  => 'nullable|string',
            'cover_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required'        => 'Every game needs a title.',
            'genre.required'        => 'Please select a genre.',
            'platform.required'     => 'Please select a platform.',
            'developer.required'    => 'Please enter the developer name.',
            'release_date.required' => 'Please enter the release date.',
            'status.required'       => 'Please select a status.',
            'status.in'             => 'Invalid status selected.',
            'price.numeric'         => 'Price must be a number.',
            'price.min'             => 'Price cannot be negative.',
            'cover_image.image'     => 'The cover must be an image file.',
            'cover_image.mimes'     => 'The cover must be a JPG, PNG, or WebP file.',
            'cover_image.max'       => 'The cover image must be under 2MB.',
        ];
    }
}
