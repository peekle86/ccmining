<?php

namespace App\Http\Controllers\Newfront;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = FaqCategory::with('faqs')
            ->whereRelation('faqs.language', 'code', app()->getLocale())
            ->get();
        return view('static.faq', compact('faqs'));
    }
}
