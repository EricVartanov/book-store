<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'adult' => ['sometimes', 'boolean'],
            'genres' => ['sometimes', 'array'],
            'genres.*' => ['sometimes', 'string', Rule::exists('genres', 'slug')],
            'cover' => ['sometimes', 'nullable', 'image'],
        ];
    }
}
