<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'cover' => ['nullable', 'image'],
            'adult' => ['required', 'boolean'],
            'genres' => ['required', 'array', 'distinct'],
            'genres.*' => [
                'string',
                Rule::exists('genres', 'slug'),
            ],
        ];
    }
}
