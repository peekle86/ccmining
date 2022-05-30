<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyContractRequest;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Models\Contract;
use App\Models\ContractPeriod;
use App\Models\HardwareItem;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContractController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('contract_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contracts = Contract::with(['user', 'hardware', 'period'])->get();

        $users = User::get();

        $hardware_items = HardwareItem::get();

        $contract_periods = ContractPeriod::get();

        return view('frontend.contracts.index', compact('contracts', 'users', 'hardware_items', 'contract_periods'));
    }

    public function create()
    {
        abort_if(Gate::denies('contract_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $hardware = HardwareItem::pluck('model', 'id')->prepend(trans('global.pleaseSelect'), '');

        $periods = ContractPeriod::pluck('period', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.contracts.create', compact('users', 'hardware', 'periods'));
    }

    public function store(StoreContractRequest $request)
    {
        $contract = Contract::create($request->all());

        return redirect()->route('frontend.contracts.index');
    }

    public function edit(Contract $contract)
    {
        abort_if(Gate::denies('contract_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $hardware = HardwareItem::pluck('model', 'id')->prepend(trans('global.pleaseSelect'), '');

        $periods = ContractPeriod::pluck('period', 'id')->prepend(trans('global.pleaseSelect'), '');

        $contract->load('user', 'hardware', 'period');

        return view('frontend.contracts.edit', compact('users', 'hardware', 'periods', 'contract'));
    }

    public function update(UpdateContractRequest $request, Contract $contract)
    {
        $contract->update($request->all());

        return redirect()->route('frontend.contracts.index');
    }

    public function show(Contract $contract)
    {
        abort_if(Gate::denies('contract_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contract->load('user', 'hardware', 'period');

        return view('frontend.contracts.show', compact('contract'));
    }

    public function destroy(Contract $contract)
    {
        abort_if(Gate::denies('contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contract->delete();

        return back();
    }

    public function massDestroy(MassDestroyContractRequest $request)
    {
        Contract::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
