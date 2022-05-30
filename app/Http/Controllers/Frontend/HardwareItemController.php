<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyHardwareItemRequest;
use App\Http\Requests\StoreHardwareItemRequest;
use App\Http\Requests\UpdateHardwareItemRequest;
use App\Models\HardwareItem;
use App\Models\HardwareType;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class HardwareItemController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('hardware_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hardwareItems = HardwareItem::with(['algoritm', 'media'])->get();

        $hardware_types = HardwareType::get();

        return view('frontend.hardwareItems.index', compact('hardwareItems', 'hardware_types'));
    }

    public function create()
    {
        abort_if(Gate::denies('hardware_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $algoritms = HardwareType::pluck('algoritm', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.hardwareItems.create', compact('algoritms'));
    }

    public function store(StoreHardwareItemRequest $request)
    {
        $hardwareItem = HardwareItem::create($request->all());

        if ($request->input('photo', false)) {
            $hardwareItem->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $hardwareItem->id]);
        }

        return redirect()->route('frontend.hardware-items.index');
    }

    public function edit(HardwareItem $hardwareItem)
    {
        abort_if(Gate::denies('hardware_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $algoritms = HardwareType::pluck('algoritm', 'id')->prepend(trans('global.pleaseSelect'), '');

        $hardwareItem->load('algoritm');

        return view('frontend.hardwareItems.edit', compact('algoritms', 'hardwareItem'));
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

        return redirect()->route('frontend.hardware-items.index');
    }

    public function show(HardwareItem $hardwareItem)
    {
        abort_if(Gate::denies('hardware_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hardwareItem->load('algoritm');

        return view('frontend.hardwareItems.show', compact('hardwareItem'));
    }

    public function destroy(HardwareItem $hardwareItem)
    {
        abort_if(Gate::denies('hardware_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hardwareItem->delete();

        return back();
    }

    public function massDestroy(MassDestroyHardwareItemRequest $request)
    {
        HardwareItem::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('hardware_item_create') && Gate::denies('hardware_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new HardwareItem();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
