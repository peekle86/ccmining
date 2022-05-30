<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\ContentPage;
use Illuminate\Http\Request;

class ContentPageController extends Controller
{
    public function index($url)
    {
        $lang_id = Language::whereCode(app()->currentLocale())->pluck('id')->first();
        $page = ContentPage::whereUrl($url)->whereLanguageId($lang_id)->first();
        if( !$page ) {
            $page = ContentPage::whereUrl($url)->firstOrFail();
        }
        return view('pages.terms', compact('page'));
    }
}
