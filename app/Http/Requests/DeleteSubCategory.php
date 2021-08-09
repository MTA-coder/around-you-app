<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteSubCategory extends FormRequest
{
    public function validationData()
    {
        return array_merge($this->all(), $this->route()->parameters());
    }

    public function rules()
    {
        return [
            'subCategory_id' => ['required', 'integer', Rule::exists('sub_categories', 'id')->whereNull('deleted_at')]
        ];
    }
}
