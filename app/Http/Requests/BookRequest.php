<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'authors' => ['required', 'string', 'max:255'],
            'description' => ['string', 'min:150'],
            'released_at' => ['required','string'],
            'cover_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
            'pages' => ['required', 'integer'],
            'language_code' => ['required', 'max:3'],
            'isbn' => ['required', 'max:13'],
            'in_stock' => ['integer', 'required'],
            'genres' => ['required']
        ];
    }
}
