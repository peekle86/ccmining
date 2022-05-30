<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyChatRequest;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;
use App\Models\Chat;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChatController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('chat_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $chats = Chat::with(['user'])->get();

        $users = User::get();

        return view('frontend.chats.index', compact('chats', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('chat_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.chats.create', compact('users'));
    }

    public function store(StoreChatRequest $request)
    {
        $chat = Chat::create($request->all());

        return redirect()->route('frontend.chats.index');
    }

    public function edit(Chat $chat)
    {
        abort_if(Gate::denies('chat_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $chat->load('user');

        return view('frontend.chats.edit', compact('users', 'chat'));
    }

    public function update(UpdateChatRequest $request, Chat $chat)
    {
        $chat->update($request->all());

        return redirect()->route('frontend.chats.index');
    }

    public function show(Chat $chat)
    {
        abort_if(Gate::denies('chat_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $chat->load('user', 'chatMessages');

        return view('frontend.chats.show', compact('chat'));
    }

    public function destroy(Chat $chat)
    {
        abort_if(Gate::denies('chat_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $chat->delete();

        return back();
    }

    public function massDestroy(MassDestroyChatRequest $request)
    {
        Chat::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
