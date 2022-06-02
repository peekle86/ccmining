<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQiwiApiRequest extends FormRequest
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
