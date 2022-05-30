<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class HardwareItemController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('hardware_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = HardwareItem::with(['algoritm'])->select(sprintf('%s.*', (new HardwareItem())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'hardware_item_show';
                $editGate = 'hardware_item_edit';
                $deleteGate = 'hardware_item_delete';
                $crudRoutePart = 'hardware-items';

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
            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : '';
            });
            $table->editColumn('model', function ($row) {
                return $row->model ? $row->model : '';
            });
            $table->editColumn('hashrate', function ($row) {
                return $row->hashrate ? $row->hashrate : '';
            });
            $table->editColumn('power', function ($row) {
                return $row->power ? $row->power : '';
            });
            $table->addColumn('algoritm_algoritm', function ($row) {
                return $row->algoritm ? $row->algoritm->algoritm : '';
            });

            $table->editColumn('profitability', function ($row) {
                return $row->profitability ? $row->profitability : '';
            });
            $table->editColumn('available', function ($row) {
                return $row->available ? HardwareItem::AVAILABLE_RADIO[$row->available] : '';
            });
            $table->editColumn('photo', function ($row) {
                if ($photo = $row->photo) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('url', function ($row) {
                return $row->url ? $row->url : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'algoritm', 'photo']);

            return $table->make(true);
        }

        $hardware_types = HardwareType::get();

        return view('admin.hardwareItems.index', compact('hardware_types'));
    }

    public function create()
    {
        abort_if(Gate::denies('hardware_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $algoritms = HardwareType::pluck('algoritm', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.hardwareItems.create', compact('algoritms'));
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

        return redirect()->route('admin.hardware-items.index');
    }

    public function edit(HardwareItem $hardwareItem)
    {
        abort_if(Gate::denies('hardware_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $algoritms = HardwareType::pluck('algoritm', 'id')->prepend(trans('global.pleaseSelect'), '');

        $hardwareItem->load('algoritm');

        return view('admin.hardwareItems.edit', compact('algoritms', 'hardwareItem'));
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

        return redirect()->route('admin.hardware-items.index');
    }

    public function show(HardwareItem $hardwareItem)
    {
        abort_if(Gate::denies('hardware_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hardwareItem->load('algoritm');

        return view('admin.hardwareItems.show', compact('hardwareItem'));
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
