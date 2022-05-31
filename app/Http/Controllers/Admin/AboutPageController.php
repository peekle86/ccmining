<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MassDestroyAboutPageRequest;
use App\Http\Requests\UpdateAboutPageRequest;
use App\Models\AboutPage;
use Gate;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAboutPageRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AboutPageController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('content_page_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $aboutPages = AboutPage::with(['language', 'media'])->get();

        return view('admin.aboutPages.index', compact('aboutPages'));
    }

    public function create()
    {
        abort_if(Gate::denies('content_page_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $languages = Language::pluck('name', 'id');

        return view('admin.aboutPages.create', compact('languages'));
    }

    public function store(StoreAboutPageRequest $request)
    {
        $aboutPage = AboutPage::create($request->all());
        if ($request->input('featured_image', false)) {
            $aboutPage->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $aboutPage->id]);
        }

        return redirect()->route('admin.about-page.index');
    }

    public function edit(AboutPage $aboutPage)
    {
        abort_if(Gate::denies('content_page_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $languages = Language::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $aboutPage->load('language');

        return view('admin.aboutPages.edit', compact('languages', 'aboutPage'));
    }

    public function update(UpdateAboutPageRequest $request, AboutPage $aboutPage)
    {
        $aboutPage->update($request->all());
        if ($request->input('featured_image', false)) {
            if (!$aboutPage->featured_image || $request->input('featured_image') !== $aboutPage->featured_image->file_name) {
                if ($aboutPage->featured_image) {
                    $aboutPage->featured_image->delete();
                }
                $aboutPage->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
            }
        } elseif ($aboutPage->featured_image) {
            $aboutPage->featured_image->delete();
        }

        return redirect()->route('admin.about-page.index');
    }

    public function show(AboutPage $aboutPage)
    {
        abort_if(Gate::denies('content_page_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $aboutPage->load('language');

        return view('admin.aboutPages.show', compact('aboutPage'));
    }

    public function destroy(AboutPage $aboutPage)
    {
        abort_if(Gate::denies('content_page_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $aboutPage->delete();

        return back();
    }

    public function massDestroy(MassDestroyAboutPageRequest $request)
    {
        AboutPage::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('content_page_create') && Gate::denies('content_page_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new AboutPage();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
