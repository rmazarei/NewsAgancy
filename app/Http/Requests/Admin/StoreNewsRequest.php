<?php

namespace App\Http\Requests\Admin;

use Hekmatinasser\Verta\Verta;
use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'published_at' => ['sometimes', 'nullable', 'date'],
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['exists:categories,id'],
            // 'cities' => ['required', 'array', 'min:1'],
            // 'cities.*' => ['exists:cities,id'],
            'main_image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'gallery' => ['sometimes', 'array'],
            'gallery.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'featured' => 'sometimes|boolean', // <-- افزودن
        ];
    }
}
