<?php

namespace App\Http\Requests;

use App\Models\Checkout;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCheckoutRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('checkout_edit');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            // 'items.*' => [
            //     'integer',
            // ],
            'items' => [
                'required',
                'array',
            ],
            'btc_price' => [
                'numeric'
            ],
            'tx' => [
                'string',
                'nullable'
            ]
        ];
    }
}
