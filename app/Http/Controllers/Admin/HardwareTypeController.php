<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyHardwareTypeRequest;
use App\Http\Requests\StoreHardwareTypeRequest;
use App\Http\Requests\UpdateHardwareTypeRequest;
use App\Models\HardwareType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class HardwareTypeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('hardware_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = HardwareType::query()->select(sprintf('%s.*', (new HardwareType())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'hardware_type_show';
                $editGate = 'hardware_type_edit';
                $deleteGate = 'hardware_type_delete';
                $crudRoutePart = 'hardware-types';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('symbol', function ($row) {
                return $row->symbol ? $row->symbol : '';
            });
            $table->editColumn('algoritm', function ($row) {
                return $row->algoritm ? $row->algoritm : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.hardwareTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('hardware_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hardwareTypes.create');
    }

    public function store(StoreHardwareTypeRequest $request)
    {
        $hardwareType = HardwareType::create($request->all());

        return redirect()->route('admin.hardware-types.index');
    }

    public function edit(HardwareType $hardwareType)
    {
        abort_if(Gate::denies('hardware_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hardwareTypes.edit', compact('hardwareType'));
    }

    public function update(UpdateHardwareTypeRequest $request, HardwareType $hardwareType)
    {
        $hardwareType->update($request->all());

        return redirect()->route('admin.hardware-types.index');
    }

    public function show(HardwareType $hardwareType)
    {
        abort_if(Gate::denies('hardware_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hardwareTypes.show', compact('hardwareType'));
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
