<?php


namespace App;


use App\Models\Language;
use App\Models\Page;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class PageTitleHelper
{
    static function get(){
        $path = Request::path();
        if(Str::startsWith($path,"/")){
            $path = Str::substr($path,1);
        }
        $lang = Language::query()->where("code",App::getLocale())->first();
        $page = Page::query()->where("url",$path)->where("language_id",$lang->id)->first();
        echo $page->title ?? config('app.name');
    }
}