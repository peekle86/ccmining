<?php

namespace App\Http\Requests;

use App\Models\Transaction;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTransactionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('transaction_create');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'type' => [
                'required',
            ],
            'amount' => [
                'string',
                'required',
            ],
            'in_usd' => [
                'float',
                'nullable'
            ],
            'status' => [
                'required',
            ],
            'currency_id' => [
                'required',
                'integer',
            ],
            'source' => [
                'string',
                'nullable',
            ],
            'target' => [
                'string',
                'nullable',
            ],
        ];
    }
}
