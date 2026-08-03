<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')
                    ->ignore($this->category),
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')
                    ->ignore($this->category),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'boolean',
            ],

        ];
    }
}
