<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTransactionRequest;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Contract;
use App\Models\Currency;
use App\Models\Transaction;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WithdrawlController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('transaction_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Transaction::where('type', 4)->with(['user', 'contract', 'currency'])->select(sprintf('%s.*', (new Transaction())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'transaction_show';
                $editGate = 'transaction_edit';
                $deleteGate = 'transaction_delete';
                $crudRoutePart = 'transactions';

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
            $table->addColumn('user_email', function ($row) {
                return $row->user ? $row->user->email : '';
            });

            $table->editColumn('user.name', function ($row) {
                return $row->user ? (is_string($row->user) ? $row->user : $row->user->name) : '';
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? Transaction::TYPE_RADIO[$row->type] : '';
            });
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Transaction::STATUS_RADIO[$row->status] : '';
            });
            $table->addColumn('contract_ended_at', function ($row) {
                return $row->contract ? $row->contract->ended_at : '';
            });

            $table->addColumn('currency_name', function ($row) {
                return $row->currency ? $row->currency->name : '';
            });

            $table->editColumn('source', function ($row) {
                return $row->source ? $row->source : '';
            });
            $table->editColumn('target', function ($row) {
                return $row->target ? $row->target : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'contract', 'currency']);

            return $table->make(true);
        }

        $users      = User::get();
        $contracts  = Contract::get();
        $currencies = Currency::get();

        return view('admin.withdrawls.index', compact('users', 'contracts', 'currencies'));
    }

    // public function create()
    // {
    //     abort_if(Gate::denies('withdrawl_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     return view('admin.withdrawls.create');
    // }

    // public function store(StoreWithdrawlRequest $request)
    // {
    //     $withdrawl = Withdrawl::create($request->all());

    //     return redirect()->route('admin.withdrawls.index');
    // }

    // public function edit(Withdrawl $withdrawl)
    // {
    //     abort_if(Gate::denies('withdrawl_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     return view('admin.withdrawls.edit', compact('withdrawl'));
    // }

    public function update(UpdateWithdrawlRequest $request, Withdrawl $withdrawl)
    {
        $withdrawl->update($request->all());

        return redirect()->route('admin.withdrawls.index');
    }

    public function show(Withdrawl $withdrawl)
    {
        abort_if(Gate::denies('withdrawl_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.withdrawls.show', compact('withdrawl'));
    }

    // public function destroy(Withdrawl $withdrawl)
    // {
    //     abort_if(Gate::denies('withdrawl_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $withdrawl->delete();

    //     return back();
    // }

    public function massDestroy(MassDestroyTransactionRequest $request)
    {
        Transaction::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
