<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentCheckoutRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'payment' => 'required|not_in:0',
            'promo_code' => 'sometimes'
        ];
    }

    public function attributes()
    {
        return [
            'payment' => __('request_validation.payment'),
            'promo_code' => __('request_validation.promocode')
        ];
    }

    public function messages()
    {
        return [
            'payment.not_in' => __('request_validation.payment_not_in')
        ];
    }
}
