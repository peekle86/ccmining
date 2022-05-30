<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyContractPeriodRequest;
use App\Http\Requests\StoreContractPeriodRequest;
use App\Http\Requests\UpdateContractPeriodRequest;
use App\Models\ContractPeriod;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ContractPeriodController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('contract_period_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ContractPeriod::query()->select(sprintf('%s.*', (new ContractPeriod())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'contract_period_show';
                $editGate = 'contract_period_edit';
                $deleteGate = 'contract_period_delete';
                $crudRoutePart = 'contract-periods';

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
            $table->editColumn('period', function ($row) {
                return $row->period ? $row->period : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.contractPeriods.index');
    }

    public function create()
    {
        abort_if(Gate::denies('contract_period_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contractPeriods.create');
    }

    public function store(StoreContractPeriodRequest $request)
    {
        $contractPeriod = ContractPeriod::create($request->all());

        return redirect()->route('admin.contract-periods.index');
    }

    public function edit(ContractPeriod $contractPeriod)
    {
        abort_if(Gate::denies('contract_period_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contractPeriods.edit', compact('contractPeriod'));
    }

    public function update(UpdateContractPeriodRequest $request, ContractPeriod $contractPeriod)
    {
        $contractPeriod->update($request->all());

        return redirect()->route('admin.contract-periods.index');
    }

    public function show(ContractPeriod $contractPeriod)
    {
        abort_if(Gate::denies('contract_period_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contractPeriods.show', compact('contractPeriod'));
    }

    public function destroy(ContractPeriod $contractPeriod)
    {
        abort_if(Gate::denies('contract_period_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contractPeriod->delete();

        return back();
    }

    public function massDestroy(MassDestroyContractPeriodRequest $request)
    {
        ContractPeriod::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
