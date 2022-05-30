<?php

namespace App\Http\Requests;

use App\Models\Mail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMailRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('mail_create');
    }

    public function rules()
    {
        return [
            'type' => [
                'required',
            ],
        ];
    }
}
