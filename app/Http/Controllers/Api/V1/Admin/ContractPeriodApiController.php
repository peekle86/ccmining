<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContractPeriodRequest;
use App\Http\Requests\UpdateContractPeriodRequest;
use App\Http\Resources\Admin\ContractPeriodResource;
use App\Models\ContractPeriod;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContractPeriodApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('contract_period_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContractPeriodResource(ContractPeriod::all());
    }

    public function store(StoreContractPeriodRequest $request)
    {
        $contractPeriod = ContractPeriod::create($request->all());

        return (new ContractPeriodResource($contractPeriod))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ContractPeriod $contractPeriod)
    {
        abort_if(Gate::denies('contract_period_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContractPeriodResource($contractPeriod);
    }

    public function update(UpdateContractPeriodRequest $request, ContractPeriod $contractPeriod)
    {
        $contractPeriod->update($request->all());

        return (new ContractPeriodResource($contractPeriod))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ContractPeriod $contractPeriod)
    {
        abort_if(Gate::denies('contract_period_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contractPeriod->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
