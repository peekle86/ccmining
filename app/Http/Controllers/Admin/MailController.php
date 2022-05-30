<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyMailRequest;
use App\Http\Requests\StoreMailRequest;
use App\Http\Requests\UpdateMailRequest;
use App\Models\Language;
use App\Models\Mail;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class MailController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('mail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mails = Mail::with(['language'])->get();

        return view('admin.mails.index', compact('mails'));
    }

    public function create()
    {
        abort_if(Gate::denies('mail_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $languages = Language::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.mails.create', compact('languages'));
    }

    public function store(StoreMailRequest $request)
    {
        $mail = Mail::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $mail->id]);
        }

        return redirect()->route('admin.mails.index');
    }

    public function edit(Mail $mail)
    {
        abort_if(Gate::denies('mail_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $languages = Language::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $mail->load('language');

        return view('admin.mails.edit', compact('languages', 'mail'));
    }

    public function update(UpdateMailRequest $request, Mail $mail)
    {
        $mail->update($request->all());

        return redirect()->route('admin.mails.index');
    }

    public function show(Mail $mail)
    {
        abort_if(Gate::denies('mail_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mail->load('language');

        return view('admin.mails.show', compact('mail'));
    }

    public function destroy(Mail $mail)
    {
        abort_if(Gate::denies('mail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mail->delete();

        return back();
    }

    public function massDestroy(MassDestroyMailRequest $request)
    {
        Mail::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('mail_create') && Gate::denies('mail_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Mail();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
