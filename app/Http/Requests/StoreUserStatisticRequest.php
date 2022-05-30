<?php

namespace App\Http\Requests;

use App\Models\UserStatistic;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserStatisticRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_statistic_create');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'ip' => [
                'string',
                'nullable',
            ],
        ];
    }
}
