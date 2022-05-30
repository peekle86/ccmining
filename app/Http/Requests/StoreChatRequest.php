<?php

namespace App\Http\Requests;

use App\Models\Chat;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreChatRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('chat_create');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'name' => [
                'string',
                'nullable',
            ],
            'chat_name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
