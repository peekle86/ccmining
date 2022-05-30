<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyContractPeriodRequest;
use App\Http\Requests\StoreContractPeriodRequest;
use App\Http\Requests\UpdateContractPeriodRequest;
use App\Models\ContractPeriod;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContractPeriodController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('contract_period_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contractPeriods = ContractPeriod::all();

        return view('frontend.contractPeriods.index', compact('contractPeriods'));
    }

    public function create()
    {
        abort_if(Gate::denies('contract_period_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.contractPeriods.create');
    }

    public function store(StoreContractPeriodRequest $request)
    {
        $contractPeriod = ContractPeriod::create($request->all());

        return redirect()->route('frontend.contract-periods.index');
    }

    public function edit(ContractPeriod $contractPeriod)
    {
        abort_if(Gate::denies('contract_period_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.contractPeriods.edit', compact('contractPeriod'));
    }

    public function update(UpdateContractPeriodRequest $request, ContractPeriod $contractPeriod)
    {
        $contractPeriod->update($request->all());

        return redirect()->route('frontend.contract-periods.index');
    }

    public function show(ContractPeriod $contractPeriod)
    {
        abort_if(Gate::denies('contract_period_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.contractPeriods.show', compact('contractPeriod'));
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
