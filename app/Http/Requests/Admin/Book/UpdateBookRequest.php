<?php

namespace App\Http\Requests\Admin\Book;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $bookId = $this->route('book') ? $this->route('book')->id : $this->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'isbn' => ['required', 'string', 'max:50', 'unique:books,isbn,' . $bookId],
            'category_id' => ['required', 'exists:categories,id'],
            'author_id' => ['required', 'exists:authors,id'],
            'publisher_id' => ['required', 'exists:publishers,id'],
            'language_id' => ['required', 'exists:languages,id'],
            'edition' => ['required', 'integer', 'min:1'],
            'publish_year' => ['nullable', 'integer', 'between:1000,' . date('Y')],
            'total_pages' => ['nullable', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'summary' => ['nullable', 'string'],
            'status' => ['required', 'in:available,archived,out_of_stock'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }
}