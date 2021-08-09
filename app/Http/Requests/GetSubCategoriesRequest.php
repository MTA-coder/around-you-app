<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class
GetSubCategoriesRequest extends FormRequest
{

    public function validationData()
    {
        return array_merge($this->all(), $this->route()->parameters());
    }

    public function rules()
    {
        return [
            'categoryId' => ['required', 'integer', Rule::exists('categories', 'id')->whereNull('deleted_at')]
        ];
    }
}
