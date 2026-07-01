<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'min_age' => ['required', 'integer', 'min:0', 'max:120'],
            'max_age' => ['required', 'integer', 'gte:min_age', 'max:120'],
            'min_credit_score' => ['required', 'integer', 'min:0', 'max:1000'],
            'allowed_employment_types' => ['required', 'array', 'min:1'],
            'allowed_employment_types.*' => ['required', 'string', 'max:255'],
            'allowed_salary_types' => ['required', 'array', 'min:1'],
            'allowed_salary_types.*' => ['required', 'string', 'max:255'],
            'min_salary' => ['required', 'numeric', 'min:0'],
        ];
    }
}
