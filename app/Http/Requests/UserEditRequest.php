<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserEditRequest extends FormRequest
{

    public function rules()
    {
        return [
            'first_name' => ['string'],
            'last_name' => ['string'],
            'email' => ['email', Rule::unique('users', 'email')],
            'password' => ['string'],
            'phone' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
            'gender' => ['string'],
            'city' => ['nullable', 'string']
        ];
    }
}
