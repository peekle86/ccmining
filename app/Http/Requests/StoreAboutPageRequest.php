<?php
/**
 * Created by PhpStorm.
 * User: LIGHTNING
 * Date: 31.05.2022
 * Time: 10:27
 */

namespace App\Http\Requests;


use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreAboutPageRequest extends FormRequest
{

    public function authorize()
    {
        return Gate::allows('content_page_create');
    }

    public function rules()
    {
        return [
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
