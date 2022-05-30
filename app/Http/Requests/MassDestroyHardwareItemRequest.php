<?php

namespace App\Http\Requests;

use App\Models\HardwareItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyHardwareItemRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('hardware_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:hardware_items,id',
        ];
    }
}
