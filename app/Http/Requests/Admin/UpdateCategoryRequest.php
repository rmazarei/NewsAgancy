<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $category = $this->route('category');

        return [
            'title' => ['sometimes', 'string', 'max:255', Rule::unique('categories', 'title')->ignore($category)],
            'order' => ['sometimes', 'integer', 'min:0'],
        ];
    }
}
