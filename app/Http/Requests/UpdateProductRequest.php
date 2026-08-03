<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'brand_id' => [
                'required',
                'exists:brands,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')
                    ->ignore($this->product),
            ],

            'sku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'sku')
                    ->ignore($this->product),
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'discount_price' => [
                'nullable',
                'numeric',
                'min:0',
                'lte:price',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            'max_order_quantity' => [
                'required',
                'integer',
                'min:1',
                
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp,avif',
                'max:2048',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'featured' => [
                'required',
                'boolean',
            ],

            'status' => [
                'required',
                'boolean',
            ],

        ];
    }
}
