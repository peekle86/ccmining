<?php

namespace App\Http\Requests;

use App\Models\WalletNetwork;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyWalletNetworkRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('wallet_network_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:wallet_networks,id',
        ];
    }
}
