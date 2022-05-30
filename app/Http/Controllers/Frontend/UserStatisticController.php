<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserStatisticRequest;
use App\Http\Requests\StoreUserStatisticRequest;
use App\Http\Requests\UpdateUserStatisticRequest;
use App\Models\User;
use App\Models\UserStatistic;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserStatisticController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_statistic_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userStatistics = UserStatistic::with(['user'])->get();

        $users = User::get();

        return view('frontend.userStatistics.index', compact('userStatistics', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_statistic_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.userStatistics.create', compact('users'));
    }

    public function store(StoreUserStatisticRequest $request)
    {
        $userStatistic = UserStatistic::create($request->all());

        return redirect()->route('frontend.user-statistics.index');
    }

    public function edit(UserStatistic $userStatistic)
    {
        abort_if(Gate::denies('user_statistic_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userStatistic->load('user');

        return view('frontend.userStatistics.edit', compact('users', 'userStatistic'));
    }

    public function update(UpdateUserStatisticRequest $request, UserStatistic $userStatistic)
    {
        $userStatistic->update($request->all());

        return redirect()->route('frontend.user-statistics.index');
    }

    public function show(UserStatistic $userStatistic)
    {
        abort_if(Gate::denies('user_statistic_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userStatistic->load('user');

        return view('frontend.userStatistics.show', compact('userStatistic'));
    }

    public function destroy(UserStatistic $userStatistic)
    {
        abort_if(Gate::denies('user_statistic_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userStatistic->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserStatisticRequest $request)
    {
        UserStatistic::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
