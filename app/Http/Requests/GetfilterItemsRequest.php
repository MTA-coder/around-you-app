<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetfilterItemsRequest extends FormRequest
{

    public function validationData()
    {
        return array_merge($this->all(), $this->route()->parameters());
    }

    public function rules()
    {
        return [
            'lowPrice' => ['nullable', 'numeric', 'min:0'],
            'highPrice' => ['nullable', 'numeric', 'min:0'],
            'isNew' => ['nullable', 'string'],
            'order' => ['nullable', 'string'],
            'city' => ['string', 'nullable'],
            'subCategory_id' => ['nullable', 'integer', Rule::exists('sub_categories', 'id')->whereNull('deleted_at')]

        ];
    }
}
