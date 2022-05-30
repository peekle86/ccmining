<?php

namespace App\Http\Requests;

use App\Models\Setting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('setting_edit');
    }

    public function rules()
    {
        return [
            'price_kwt' => [
                'required',
            ],
            'price_th' => [
                'numeric',
                'required',
            ],
            'profit_th' => [
                'numeric',
                'required',
            ],
            'max_th' => [
                'numeric',
                'required',
            ],
            'ref' => [
                'numeric',
            ],
            'active' => [
                'required',
            ],
            'proxy' => [
                'nullable',
            ],
        ];
    }
}
