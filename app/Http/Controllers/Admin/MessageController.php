<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('message_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Message::with(['from', 'to', 'chat'])->select(sprintf('%s.*', (new Message())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'message_show';
                $editGate = 'message_edit';
                $deleteGate = 'message_delete';
                $crudRoutePart = 'messages';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('message', function ($row) {
                return $row->message ? $row->message : '';
            });
            $table->addColumn('from_email', function ($row) {
                return $row->from ? $row->from->email : '';
            });

            $table->editColumn('from.name', function ($row) {
                return $row->from ? (is_string($row->from) ? $row->from : $row->from->name) : '';
            });
            $table->addColumn('to_email', function ($row) {
                return $row->to ? $row->to->email : '';
            });

            $table->editColumn('to.name', function ($row) {
                return $row->to ? (is_string($row->to) ? $row->to : $row->to->name) : '';
            });
            $table->editColumn('read', function ($row) {
                return $row->read ? Message::READ_RADIO[$row->read] : '';
            });
            $table->addColumn('chat_chat_name', function ($row) {
                return $row->chat ? $row->chat->chat_name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'from', 'to', 'chat']);

            return $table->make(true);
        }

        $users = User::get();
        $chats = Chat::get();

        return view('admin.messages.index', compact('users', 'chats'));
    }

    public function create()
    {
        abort_if(Gate::denies('message_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $froms = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tos = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $chats = Chat::pluck('chat_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.messages.create', compact('froms', 'tos', 'chats'));
    }

    public function store(StoreMessageRequest $request)
    {
        $message = Message::create($request->all());

        return redirect()->route('admin.messages.index');
    }

    public function edit(Message $message)
    {
        abort_if(Gate::denies('message_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $froms = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tos = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $chats = Chat::pluck('chat_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $message->load('from', 'to', 'chat');

        return view('admin.messages.edit', compact('froms', 'tos', 'chats', 'message'));
    }

    public function update(UpdateMessageRequest $request, Message $message)
    {
        $message->update($request->all());

        return redirect()->route('admin.messages.index');
    }

    public function show(Message $message)
    {
        abort_if(Gate::denies('message_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $message->load('from', 'to', 'chat');

        return view('admin.messages.show', compact('message'));
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
