<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBalanceRequest;
use App\Http\Requests\StoreBalanceRequest;
use App\Http\Requests\UpdateBalanceRequest;
use App\Models\Balance;
use App\Models\Currency;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BalanceController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('balance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users      = User::get();
        $currencies = Currency::get();

        if ($request->ajax()) {
            $query = User::with(['userBalances'])->select(sprintf('%s.*', (new User())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', function ($row) {
                return '<a class="btn btn-xs btn-primary" href="' . route('admin.users.show', $row->id) . '">'
                    . trans('global.view') .
                '</a>';
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('user_email', function ($row) {
                return $row->email ? $row->email : '';
            });

            foreach( $currencies as $cur ) {
                $table->addColumn('currency_'.$cur->symbol, function ($row) use ($cur) {
                    $balance = $row->userBalances()->get();

                    if( $balance->count() ) {
                        $bal = $balance->where('currency_id', $cur->id)->first();
                        return $bal ? $bal->amount : 0;
                    } else {
                        return 0;
                    }
                });
            }

            $table->rawColumns(['actions', 'placeholder', 'user', 'currency']);

            return $table->make(true);
        }



        return view('admin.balances.index', compact('users', 'currencies'));
    }

    public function create()
    {
        abort_if(Gate::denies('balance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $currencies = Currency::pluck('symbol', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.balances.create', compact('users', 'currencies'));
    }

    public function store(StoreBalanceRequest $request)
    {
        $balance = Balance::create($request->all());

        return redirect()->route('admin.balances.index');
    }

    public function edit(Balance $balance)
    {
        abort_if(Gate::denies('balance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $currencies = Currency::pluck('symbol', 'id')->prepend(trans('global.pleaseSelect'), '');

        $balance->load('user', 'currency');

        return view('admin.balances.edit', compact('users', 'currencies', 'balance'));
    }

    public function update(UpdateBalanceRequest $request, Balance $balance)
    {
        $balance->update($request->all());

        return redirect()->route('admin.balances.index');
    }

    public function show(Balance $balance)
    {
        abort_if(Gate::denies('balance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $balance->load('user', 'currency');

        return view('admin.balances.show', compact('balance'));
    }

    public function destroy(Balance $balance)
    {
        abort_if(Gate::denies('balance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $balance->delete();

        return back();
    }

    public function massDestroy(MassDestroyBalanceRequest $request)
    {
        Balance::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
