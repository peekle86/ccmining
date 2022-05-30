<?php

namespace App\Http\Requests;

use App\Models\ContentPage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateContentPageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('content_page_edit');
    }

    public function rules()
    {
        return [
            'url' => [
                'string',
                'required'
            ],
            'title' => [
                'string',
                'required',
            ],
            'description' => [
                'string',
                'nullable',
            ],
            'language_id' => [
                'nullable',
                'integer'
            ],
        ];
    }
}
