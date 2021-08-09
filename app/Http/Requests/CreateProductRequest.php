<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'subCategory_id' => ['integer', 'nullable', Rule::exists('sub_categories', 'id')],
            'name' => ['string', 'required'],
            'price' => ['numeric', 'required', 'min:1'],
            'isNew' => ['boolean', 'required'],
            'description' => ['string', 'required'],
            'city' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
        ];
    }
}
