<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUser extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'string'],
            'confirm_password' => ['required', 'string', 'same:password'],
            'phone' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
            'gender' => ['required', 'string'],
            'city' => ['nullable', 'string']
        ];
    }
}
