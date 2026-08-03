<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\ValidationRule;
use Propaganistas\LaravelPhone\Rules\Phone;

class RegisterRequest extends FormRequest
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
            ],

            'phone_country' => [
                'required',
                'in:EG,SA,AE,KW,QA,BH,OM,JO,LB',
            ],

            'phone' => [
                'required',
                'unique:users,phone',
                new Phone($this->input('phone_country')),
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(6),
            ],

        ];
    }
}