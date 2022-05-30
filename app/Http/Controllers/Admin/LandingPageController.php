<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLandingPageRequest;
use App\Http\Requests\StoreLandingPageRequest;
use App\Http\Requests\UpdateLandingPageRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LandingPageController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('landing_page_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.landingPages.index');
    }

    public function create()
    {
        abort_if(Gate::denies('landing_page_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.landingPages.create');
    }

    public function store(StoreLandingPageRequest $request)
    {
        $landingPage = LandingPage::create($request->all());

        return redirect()->route('admin.landing-pages.index');
    }

    public function edit(LandingPage $landingPage)
    {
        abort_if(Gate::denies('landing_page_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.landingPages.edit', compact('landingPage'));
    }

    public function update(UpdateLandingPageRequest $request, LandingPage $landingPage)
    {
        $landingPage->update($request->all());

        return redirect()->route('admin.landing-pages.index');
    }

    public function show(LandingPage $landingPage)
    {
        abort_if(Gate::denies('landing_page_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.landingPages.show', compact('landingPage'));
    }

    public function destroy(LandingPage $landingPage)
    {
        abort_if(Gate::denies('landing_page_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $landingPage->delete();

        return back();
    }

    public function massDestroy(MassDestroyLandingPageRequest $request)
    {
        LandingPage::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
