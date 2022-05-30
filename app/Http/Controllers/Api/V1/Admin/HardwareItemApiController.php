<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreHardwareItemRequest;
use App\Http\Requests\UpdateHardwareItemRequest;
use App\Http\Resources\Admin\HardwareItemResource;
use App\Models\HardwareItem;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HardwareItemApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('hardware_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new HardwareItemResource(HardwareItem::with(['algoritm'])->get());
    }

    public function store(StoreHardwareItemRequest $request)
    {
        $hardwareItem = HardwareItem::create($request->all());

        if ($request->input('photo', false)) {
            $hardwareItem->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        return (new HardwareItemResource($hardwareItem))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(HardwareItem $hardwareItem)
    {
        abort_if(Gate::denies('hardware_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new HardwareItemResource($hardwareItem->load(['algoritm']));
    }

    public function update(UpdateHardwareItemRequest $request, HardwareItem $hardwareItem)
    {
        $hardwareItem->update($request->all());

        if ($request->input('photo', false)) {
            if (!$hardwareItem->photo || $request->input('photo') !== $hardwareItem->photo->file_name) {
                if ($hardwareItem->photo) {
                    $hardwareItem->photo->delete();
                }
                $hardwareItem->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($hardwareItem->photo) {
            $hardwareItem->photo->delete();
        }

        return (new HardwareItemResource($hardwareItem))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(HardwareItem $hardwareItem)
    {
        abort_if(Gate::denies('hardware_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hardwareItem->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
