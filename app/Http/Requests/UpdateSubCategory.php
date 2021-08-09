<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubCategory extends FormRequest
{
    public function validationData()
    {
        return array_merge($this->all(), $this->route()->parameters());
    }

    public function rules()
    {
        return [
            'name' => ['string'],
            'image' => ['string'],
            'subCategory_id' => ['required', 'integer', Rule::exists('sub_categories', 'id')->whereNull('deleted_at')]
        ];
    }
}
