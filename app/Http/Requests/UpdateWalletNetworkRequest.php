<?php

namespace App\Http\Requests;

use App\Models\WalletNetwork;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateWalletNetworkRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('wallet_network_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:wallet_networks,name,' . request()->route('wallet_network')->id,
            ],
            'coingecko' => [
                'string',
                'nullable',
            ],
            'symbol' => [
                'string',
                'nullable',
            ],
            'in_usd' => [
                'string',
                'nullable',
            ],
        ];
    }
}
