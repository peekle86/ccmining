<?php

namespace App\Http\Requests;

use App\Models\HardwareItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateHardwareItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('hardware_item_edit');
    }

    public function rules()
    {
        return [
            'model' => [
                'string',
                'required',
            ],
            'hashrate' => [
                'string',
                'nullable',
            ],
            'power' => [
                'string',
                'nullable',
            ],
            'price' => [
                'string',
                'nullable'
            ],
            'algoritm_id' => [
                'required',
                'integer',
            ],
            'profitability' => [
                'string',
                'required',
            ],
            'url' => [
                'string',
                'required',
                'unique:hardware_items,url,' . request()->route('hardware_item')->id,
            ],
        ];
    }
}
