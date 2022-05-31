<?php

namespace App\Http\Controllers\Newfront;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use App\Models\ContentPage;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $content = AboutPage::whereRelation('language', 'code', app()->getLocale())
        ->firstOrFail();

        return view('pages.about', compact('content'));
    }
}
