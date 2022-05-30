<?php

namespace App\Http\Controllers\Newfront;

use App\Http\Controllers\Controller;
use App\Models\ContentPage;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $content = ContentPage::where('url', 'about')
        ->whereRelation('language', 'code', app()->getLocale())
        ->first();
        
        return view('static.about', compact('content'));
    }
}
