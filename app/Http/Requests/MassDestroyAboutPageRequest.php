<?php
/**
 * Created by PhpStorm.
 * User: LIGHTNING
 * Date: 31.05.2022
 * Time: 11:03
 */

namespace App\Http\Requests;


use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAboutPageRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('content_page_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:about_page,id',
        ];
    }
}
