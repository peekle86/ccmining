<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyHardwareTypeRequest;
use App\Http\Requests\StoreHardwareTypeRequest;
use App\Http\Requests\UpdateHardwareTypeRequest;
use App\Models\HardwareType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HardwareTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('hardware_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hardwareTypes = HardwareType::all();

        return view('frontend.hardwareTypes.index', compact('hardwareTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('hardware_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.hardwareTypes.create');
    }

    public function store(StoreHardwareTypeRequest $request)
    {
        $hardwareType = HardwareType::create($request->all());

        return redirect()->route('frontend.hardware-types.index');
    }

    public function edit(HardwareType $hardwareType)
    {
        abort_if(Gate::denies('hardware_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.hardwareTypes.edit', compact('hardwareType'));
    }

    public function update(UpdateHardwareTypeRequest $request, HardwareType $hardwareType)
    {
        $hardwareType->update($request->all());

        return redirect()->route('frontend.hardware-types.index');
    }

    public function show(HardwareType $hardwareType)
    {
        abort_if(Gate::denies('hardware_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.hardwareTypes.show', compact('hardwareType'));
    }

    public function destroy(HardwareType $hardwareType)
    {
        abort_if(Gate::denies('hardware_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hardwareType->delete();

        return back();
    }

    public function massDestroy(MassDestroyHardwareTypeRequest $request)
    {
        HardwareType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
