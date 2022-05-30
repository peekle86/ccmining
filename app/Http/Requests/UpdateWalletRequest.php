<?php

namespace App\Http\Requests;

use App\Models\Wallet;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateWalletRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('wallet_edit');
    }

    public function rules()
    {
        return [
            'address' => [
                'string',
                'required',
                'unique:wallets,address,' . request()->route('wallet')->id,
            ],
            'amount' => [
                'string',
                'nullable',
            ],
            'network_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
