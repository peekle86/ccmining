<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMessageRequest;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('message_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $messages = Message::with(['from', 'to', 'chat'])->get();

        $users = User::get();

        $chats = Chat::get();

        return view('frontend.messages.index', compact('messages', 'users', 'chats'));
    }

    public function create()
    {
        abort_if(Gate::denies('message_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $froms = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tos = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $chats = Chat::pluck('chat_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.messages.create', compact('froms', 'tos', 'chats'));
    }

    public function store(StoreMessageRequest $request)
    {
        $message = Message::create($request->all());

        return redirect()->route('frontend.messages.index');
    }

    public function edit(Message $message)
    {
        abort_if(Gate::denies('message_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $froms = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tos = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $chats = Chat::pluck('chat_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $message->load('from', 'to', 'chat');

        return view('frontend.messages.edit', compact('froms', 'tos', 'chats', 'message'));
    }

    public function update(UpdateMessageRequest $request, Message $message)
    {
        $message->update($request->all());

        return redirect()->route('frontend.messages.index');
    }

    public function show(Message $message)
    {
        abort_if(Gate::denies('message_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $message->load('from', 'to', 'chat');

        return view('frontend.messages.show', compact('message'));
    }

    public function destroy(Message $message)
    {
        abort_if(Gate::denies('message_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $message->delete();

        return back();
    }

    public function massDestroy(MassDestroyMessageRequest $request)
    {
        Message::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
