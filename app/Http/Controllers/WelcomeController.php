<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Review;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{

    public function index()
    {
        $reviews = $this->getReviews();
        return view('welcome', compact('reviews'));
    }

    public function getReviews()
    {
        $lang_id = Language::whereCode(app()->currentLocale())->pluck('id')->first();
        return Review::whereLanguageId($lang_id)->get();
    }
}
