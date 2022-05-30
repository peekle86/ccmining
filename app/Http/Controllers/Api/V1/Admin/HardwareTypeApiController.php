<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHardwareTypeRequest;
use App\Http\Requests\UpdateHardwareTypeRequest;
use App\Http\Resources\Admin\HardwareTypeResource;
use App\Models\HardwareType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HardwareTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('hardware_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new HardwareTypeResource(HardwareType::all());
    }

    public function store(StoreHardwareTypeRequest $request)
    {
        $hardwareType = HardwareType::create($request->all());

        return (new HardwareTypeResource($hardwareType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(HardwareType $hardwareType)
    {
        abort_if(Gate::denies('hardware_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new HardwareTypeResource($hardwareType);
    }

    public function update(UpdateHardwareTypeRequest $request, HardwareType $hardwareType)
    {
        $hardwareType->update($request->all());

        return (new HardwareTypeResource($hardwareType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(HardwareType $hardwareType)
    {
        abort_if(Gate::denies('hardware_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hardwareType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
