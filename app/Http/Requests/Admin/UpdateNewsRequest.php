<?php

namespace App\Http\Requests\Admin;

use Hekmatinasser\Verta\Verta;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $publishedAt = $this->input('published_at');

        if (filled($publishedAt) && ! preg_match('/^\d{4}-\d{2}-\d{2}/', (string) $publishedAt)) {
            $this->merge([
                'published_at' => Verta::parse($publishedAt)->datetime()->format('Y-m-d H:i:s'),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'content' => ['sometimes', 'string'],
            'published_at' => ['sometimes', 'nullable', 'date'],
            'categories' => ['sometimes', 'array', 'min:1'],
            'categories.*' => ['exists:categories,id'],
            'cities' => ['sometimes', 'array', 'min:1'],
            'cities.*' => ['exists:cities,id'],
            'main_image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'gallery' => ['sometimes', 'array'],
            'gallery.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }
}
