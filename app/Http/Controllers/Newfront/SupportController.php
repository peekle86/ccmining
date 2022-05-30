<?php

namespace App\Http\Controllers\Newfront;

use App\Models\Faq;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupportController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        $faqs = Faq::all();
        return view('newfront.support', compact('contacts', 'faqs'));
    }
}
