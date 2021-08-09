<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetUserItemrequest extends FormRequest
{

    public function validationData()
    {
        return array_merge($this->all(), $this->route()->parameters());
    }

    public function rules()
    {
        return [
            'user_id'  => ['integer', 'required', Rule::exists('users', 'id')->whereNull('deleted_at')],
        ];
    }
}
