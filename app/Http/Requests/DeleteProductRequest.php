<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteProductRequest extends FormRequest
{
    public function validationData()
    {
        return array_merge($this->all(), $this->route()->parameters());
    }

    public function rules()
    {
        return [
            'product_id' => ['integer', 'nullable', Rule::exists('products', 'id')->whereNull('deleted_at')],
        ];
    }
}
