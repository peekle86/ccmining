<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserStatisticRequest;
use App\Http\Requests\UpdateUserStatisticRequest;
use App\Http\Resources\Admin\UserStatisticResource;
use App\Models\UserStatistic;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserStatisticApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_statistic_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserStatisticResource(UserStatistic::with(['user'])->get());
    }

    public function store(StoreUserStatisticRequest $request)
    {
        $userStatistic = UserStatistic::create($request->all());

        return (new UserStatisticResource($userStatistic))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UserStatistic $userStatistic)
    {
        abort_if(Gate::denies('user_statistic_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserStatisticResource($userStatistic->load(['user']));
    }

    public function update(UpdateUserStatisticRequest $request, UserStatistic $userStatistic)
    {
        $userStatistic->update($request->all());

        return (new UserStatisticResource($userStatistic))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UserStatistic $userStatistic)
    {
        abort_if(Gate::denies('user_statistic_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userStatistic->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
