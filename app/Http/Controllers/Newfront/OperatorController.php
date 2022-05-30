<?php

namespace App\Http\Controllers\Newfront;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index()
    {
        $chats = Chat::with('chatMessages')->get()
            ->sortByDesc(function($chat, $key) {
                return $chat->chatMessages()->first()->created_at;
            });
        return view('newfront.operator', compact('chats'));
    }
}
