<?php

namespace App\Http\Requests;

use App\Models\HardwareType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreHardwareTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('hardware_type_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'pars' => [
                'int',
                'nullable',
            ],
            'symbol' => [
                'string',
                'nullable',
            ],
            'algoritm' => [
                'string',
                'nullable',
            ],
        ];
    }
}
