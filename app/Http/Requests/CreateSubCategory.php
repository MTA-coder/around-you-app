<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSubCategory extends FormRequest
{

    public function rules()
    {
        return [
            'categoryId' => ['required', 'integer', Rule::exists('categories', 'id')->whereNull('deleted_at')],
            'name' => ['string'],
            'image' => ['string']
        ];
    }
}
