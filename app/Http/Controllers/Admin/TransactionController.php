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

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('transaction_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Transaction::with(['user', 'contract', 'currency'])->select(sprintf('%s.*', (new Transaction())->table));
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
            $table->editColumn('in_usd', function ($row) {
                return $row->in_usd ? $row->in_usd : '';
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

        return view('admin.transactions.index', compact('users', 'contracts', 'currencies'));
    }

    public function create()
    {
        abort_if(Gate::denies('transaction_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $contracts = Contract::pluck('ended_at', 'id')->prepend(trans('global.pleaseSelect'), '');

        $currencies = Currency::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.transactions.create', compact('users', 'contracts', 'currencies'));
    }

    public function store(StoreTransactionRequest $request)
    {
        $transaction = Transaction::create($request->all());

        return redirect()->route('admin.transactions.index');
    }

    public function edit(Transaction $transaction)
    {
        abort_if(Gate::denies('transaction_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $contracts = Contract::pluck('ended_at', 'id')->prepend(trans('global.pleaseSelect'), '');

        $currencies = Currency::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $transaction->load('user', 'contract', 'currency');

        return view('admin.transactions.edit', compact('users', 'contracts', 'currencies', 'transaction'));
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $transaction->update($request->all());

        return redirect()->route('admin.transactions.index');
    }

    public function show(Transaction $transaction)
    {
        abort_if(Gate::denies('transaction_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transaction->load('user', 'contract', 'currency');

        return view('admin.transactions.show', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        abort_if(Gate::denies('transaction_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transaction->delete();

        return back();
    }

    public function massDestroy(MassDestroyTransactionRequest $request)
    {
        Transaction::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
