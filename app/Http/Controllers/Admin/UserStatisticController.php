<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserStatisticRequest;
use App\Http\Requests\StoreUserStatisticRequest;
use App\Http\Requests\UpdateUserStatisticRequest;
use App\Models\User;
use App\Models\UserStatistic;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserStatisticController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('user_statistic_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UserStatistic::with(['user'])->select(sprintf('%s.*', (new UserStatistic())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'user_statistic_show';
                $editGate = 'user_statistic_edit';
                $deleteGate = 'user_statistic_delete';
                $crudRoutePart = 'user-statistics';

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

            $table->editColumn('ip', function ($row) {
                return $row->ip ? $row->ip : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user']);

            return $table->make(true);
        }

        $users = User::get();

        return view('admin.userStatistics.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_statistic_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.userStatistics.create', compact('users'));
    }

    public function store(StoreUserStatisticRequest $request)
    {
        $userStatistic = UserStatistic::create($request->all());

        return redirect()->route('admin.user-statistics.index');
    }

    public function edit(UserStatistic $userStatistic)
    {
        abort_if(Gate::denies('user_statistic_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userStatistic->load('user');

        return view('admin.userStatistics.edit', compact('users', 'userStatistic'));
    }

    public function update(UpdateUserStatisticRequest $request, UserStatistic $userStatistic)
    {
        $userStatistic->update($request->all());

        return redirect()->route('admin.user-statistics.index');
    }

    public function show(UserStatistic $userStatistic)
    {
        abort_if(Gate::denies('user_statistic_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userStatistic->load('user');

        return view('admin.userStatistics.show', compact('userStatistic'));
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
