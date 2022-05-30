<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\User;
use App\Models\Contract;
use App\Models\Currency;
use App\Models\HardwareItem;
use Illuminate\Http\Request;
use App\Models\ContractPeriod;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyContractRequest;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('contract_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Contract::with(['user', 'hardware', 'period'])->select(sprintf('%s.*', (new Contract())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'contract_show';
                $editGate = 'contract_edit';
                $deleteGate = 'contract_delete';
                $crudRoutePart = 'contracts';

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
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });
            $table->addColumn('user_email', function ($row) {
                return $row->user ? $row->user->email : '';
            });

            $table->editColumn('user.name', function ($row) {
                return $row->user ? (is_string($row->user) ? $row->user : $row->user->name) : '';
            });
            $table->addColumn('hardware_model', function ($row) {
                return $row->hardware ? $row->hardware->model : '';
            });

            $table->editColumn('hardware.hashrate', function ($row) {
                return $row->hardware ? (is_string($row->hardware) ? $row->hardware : $row->hardware->hashrate) : '';
            });
            $table->addColumn('period_period', function ($row) {
                return $row->period ? $row->period->period : '';
            });

            $table->editColumn('active', function ($row) {
                return $row->active ? Contract::ACTIVE_RADIO[$row->active] : '';
            });
            $table->editColumn('percent', function ($row) {
                return $row->percent ? $row->percent : '';
            });
            $table->editColumn('currency', function ($row) {
                return $row->currency ? $row->currency->symbol : '';
            });
            $table->rawColumns(['actions', 'placeholder', 'user', 'hardware', 'period']);

            return $table->make(true);
        }

        $users            = User::get();
        $hardware_items   = HardwareItem::get();
        $contract_periods = ContractPeriod::get();
        $currencies       = Currency::get();

        return view('admin.contracts.index', compact('currencies', 'users', 'hardware_items', 'contract_periods'));
    }

    public function create()
    {
        abort_if(Gate::denies('contract_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $hardware = HardwareItem::pluck('model', 'id')->prepend(trans('global.pleaseSelect'), '');

        $periods = ContractPeriod::pluck('period', 'id')->prepend(trans('global.pleaseSelect'), '');

        $currencies = Currency::pluck('symbol', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.contracts.create', compact('users', 'hardware', 'periods', 'currencies'));
    }

    public function store(StoreContractRequest $request)
    {
        $contract = Contract::create($request->all());

        return redirect()->route('admin.contracts.index');
    }

    public function edit(Contract $contract)
    {
        abort_if(Gate::denies('contract_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $hardware = HardwareItem::pluck('model', 'id')->prepend(trans('global.pleaseSelect'), '');

        $periods = ContractPeriod::pluck('period', 'id')->prepend(trans('global.pleaseSelect'), '');

        $contract->load('user', 'hardware', 'period');

        return view('admin.contracts.edit', compact('users', 'hardware', 'periods', 'contract'));
    }

    public function update(UpdateContractRequest $request, Contract $contract)
    {
        $contract->update($request->all());

        return redirect()->route('admin.contracts.index');
    }

    public function show(Contract $contract)
    {
        abort_if(Gate::denies('contract_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contract->load('user', 'hardware', 'period');

        return view('admin.contracts.show', compact('contract'));
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
