<?php

namespace App\Http\Requests;

use App\Models\ContractPeriod;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateContractPeriodRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('contract_period_edit');
    }

    public function rules()
    {
        return [
            'period' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
