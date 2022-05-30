<?php

namespace App\Http\Controllers\Newfront;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('static.contact');
    }

    public function contactPost(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        Mail::send(
            [],
            [
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'subject' => $request->get('subject'),
                'message' => $request->get('message')
            ],
            function ($message) use($request) {
                $message->from($request->get('email'));
                $message->to(env('APP_EMAIL'), env('APP_NAME'));
                $message->subject('Contact Form - ' . $request->get('subject'));
            });

        return back()->with('success', __('welcome._thx_for_contact'));
    }
}
