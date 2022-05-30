<?php

namespace App\Http\Requests;

use App\Models\Contract;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreContractRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('contract_create');
    }

    public function rules()
    {
        return [
            'amount' => [
                'numeric',
                'required',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            'hardware_id' => [
                'required',
                'integer',
            ],
            'period_id' => [
                'required',
                'integer',
            ],
            'currency_id' => [
                'required',
                'integer',
            ],
            'ended_at' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'active' => [
                'required',
            ],
            'percent' => [
                'numeric',
            ],
            'last_earn' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}
