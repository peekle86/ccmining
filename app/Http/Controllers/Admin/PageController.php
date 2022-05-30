<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Page;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    public function index()
    {
        $data['pages'] = Page::query()->where("language_id",1)->get();
        $data['languages'] = Language::all();
        return view('admin.pages.index', $data);
    }

    public function create()
    {
        $languages = Language::all();
        return view('admin.pages.create',compact('languages'));
    }

    public function store(Request $request)
    {
        $url = parse_url($request->get("url"));

        foreach ($request->title as $lg_id => $title){
            Page::create([
                "url" => $url,
                "language_id" => $lg_id,
                "title" => $title
            ]);
        }
        return redirect()->route('admin.page.index');
    }

    public function edit(Page $page)
    {
        $languages = Language::all();
        $pages = Page::query()->where("url",$page->url)->get();
        return view('admin.pages.edit', compact('pages','languages'));
    }

    public function update(Request $request, Page $page)
    {
        $pages = Page::query()->where("url",$page->url)->get();
        foreach ($request->title as $lg_id => $title){
            $id = $pages->where("language_id" ,$lg_id)->first()->id;
            Page::find($id)->update([
                "url" => $request->get("url"),
                "title" => $title,
                "description" => $request->description[$id]
            ]);
            dump($request->description[$id]);
        }
        //return redirect()->route('admin.page.index');
        // $arr = [];

        // foreach ($request->title as $lg_id => $title){
        //     $id = $pages->where("language_id" ,$lg_id)->first()->id;
        //     $arr[$id]["url"] = $request->get("url");
        //     $arr[$id]["title"] = $request->get("title") ?? '';
        //     $arr[$id]["description"] = $request->get("description") ?? '';
        // }

        // foreach( $arr as $id => $page ) {
        //     Page::find($id)->update([
        //         "url" => $page['url'],
        //         "title" => $page['title'],
        //         "description" => $page['description']
        //     ]);
        // }
    }

    public function show(Language $language)
    {
        $language->load('languageFaqs', 'languageArticles');

        return view('admin.pages.show', compact('language'));
    }

    public function destroy(Page $page)
    {
        $pages = Page::query()->where("url",$page->url)->get();
        foreach ($pages as $page){
            $page->delete();
        }

        return back();
    }

    public function massDestroy(Request $request)
    {
        Language::whereIn('id', request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
