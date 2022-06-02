<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQiwiApiRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'nickname' => [
                'string',
                'required',
                'unique:qiwi_links,nickname',
            ],
            'login' => [
                'string',
                'required',
            ],
            'api_key' => [
                'string',
                'required',
            ],
        ];
    }
}
