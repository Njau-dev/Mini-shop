<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search'   => ['nullable', 'string'],
            'category' => ['nullable', 'integer', 'exists:categories,id'],
            'sort'     => ['nullable', 'string'],
            'order'    => ['nullable', 'in:asc,desc'],
            'view'     => ['nullable', 'in:grid,list'],
        ];
    }

    public function filters(): array
    {
        return $this->validated();
    }
}
