@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.chat.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.chats.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.chat.fields.id') }}
                        </th>
                        <td>
                            {{ $chat->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.chat.fields.user') }}
                        </th>
                        <td>
                            {{ $chat->user->email ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.chat.fields.name') }}
                        </th>
                        <td>
                            {{ $chat->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.chat.fields.chat_name') }}
                        </th>
                        <td>
                            {{ $chat->chat_name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.chats.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#chat_messages" role="tab" data-toggle="tab">
                {{ trans('cruds.message.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="chat_messages">
            @includeIf('admin.chats.relationships.chatMessages', ['messages' => $chat->chatMessages])
        </div>
    </div>
</div>

@endsection