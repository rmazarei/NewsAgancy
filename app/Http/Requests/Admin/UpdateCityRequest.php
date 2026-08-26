<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $city = $this->route('city');

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'province_id' => ['sometimes', 'exists:provinces,id'],
            'county_id' => ['sometimes', 'exists:counties,id'],
        ];
    }
}
