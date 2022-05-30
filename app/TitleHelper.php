<?php
namespace App;
use App\Models\Language;
use App\Models\Page;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

class TitleHelper
{
    static function get( $title = null, $description = null )
    {
        $path = Request::path();
        $lang = Language::where("code", App::getLocale())->first();
        $page = Page::where("url", $path)->where("language_id", $lang->id)->first();

        if( $page ) {
            return [
                "title" => $page->title,
                "description" => $page->description
            ];
        } else if ($title) {
            return [
                "title" => $title,
                "description" => $description
            ];
        } else {
            return [
                "title" => config('app.name'),
                "description" => $description
            ];
        }
    }
}
