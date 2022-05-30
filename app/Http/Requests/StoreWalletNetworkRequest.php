<?php

namespace App\Http\Requests;

use App\Models\WalletNetwork;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreWalletNetworkRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('wallet_network_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:wallet_networks',
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
