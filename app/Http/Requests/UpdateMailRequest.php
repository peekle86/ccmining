<?php

namespace App\Http\Requests;

use App\Models\Mail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMailRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('mail_edit');
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
