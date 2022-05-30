<?php

namespace App\Http\Controllers\Frontend;

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

class BalanceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('balance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $balances = Balance::with(['user', 'currency'])->get();

        $users = User::get();

        $currencies = Currency::get();

        return view('frontend.balances.index', compact('balances', 'users', 'currencies'));
    }

    public function create()
    {
        abort_if(Gate::denies('balance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $currencies = Currency::pluck('symbol', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.balances.create', compact('users', 'currencies'));
    }

    public function store(StoreBalanceRequest $request)
    {
        $balance = Balance::create($request->all());

        return redirect()->route('frontend.balances.index');
    }

    public function edit(Balance $balance)
    {
        abort_if(Gate::denies('balance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $currencies = Currency::pluck('symbol', 'id')->prepend(trans('global.pleaseSelect'), '');

        $balance->load('user', 'currency');

        return view('frontend.balances.edit', compact('users', 'currencies', 'balance'));
    }

    public function update(UpdateBalanceRequest $request, Balance $balance)
    {
        $balance->update($request->all());

        return redirect()->route('frontend.balances.index');
    }

    public function show(Balance $balance)
    {
        abort_if(Gate::denies('balance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $balance->load('user', 'currency');

        return view('frontend.balances.show', compact('balance'));
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
