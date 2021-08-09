<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateImageItemRequest extends FormRequest
{

    public function rules()
    {
        return [
            'product_id' => ['integer', 'required', Rule::exists('products', 'id')->whereNull('deleted_at')],
            'image'=>['required','string']
        ];
    }
}
