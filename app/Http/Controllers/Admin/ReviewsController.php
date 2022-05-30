<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyArticleRequest;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Language;
use App\Models\Review;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ReviewsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('reviews_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Review::get();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'reviews_show';
                $editGate = 'reviews_edit';
                $deleteGate = 'reviews_delete';
                $crudRoutePart = 'reviews';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });


            $table->addColumn('language_name', function ($row) {
                return $row->language ? $row->language->name : '';
            });

            $table->rawColumns(['actions', 'placeholder',  'language']);

            return $table->make(true);
        }


        $languages  = Language::get();

        return view('admin.reviews.index', compact( 'languages'));
    }

    public function create()
    {
        abort_if(Gate::denies('reviews_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        $languages = Language::pluck('name', 'code')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.reviews.create', compact(  'languages'));
    }

    public function store()
    {
        $article = Review::create(request()->all());


        return redirect()->route('admin.reviews.index');
    }

    public function edit(Review $review)
    {
        abort_if(Gate::denies('reviews_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');



        $languages = Language::pluck('name', 'code')->prepend(trans('global.pleaseSelect'), '');

      $review->load(  'language');

        return view('admin.reviews.edit', compact('review',   'languages'));
    }

    public function update(  Review $review)
    {
      $request=request();
      $review->update($request->all());



        return redirect()->route('admin.reviews.index');
    }

    public function show(Review $review)
    {
        abort_if(Gate::denies('reviews_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

      $review->load('language');

        return view('admin.reviews.show', compact('review'));
    }

    public function destroy(Review $review)
    {
        abort_if(Gate::denies('reviews_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

      $review->delete();

        return back();
    }

    public function massDestroy()
    {
        Review::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }


}
