@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.message.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.messages.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.message.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $message->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.message.fields.message') }}
                                    </th>
                                    <td>
                                        {{ $message->message }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.message.fields.from') }}
                                    </th>
                                    <td>
                                        {{ $message->from->email ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.message.fields.to') }}
                                    </th>
                                    <td>
                                        {{ $message->to->email ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.message.fields.read') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Message::READ_RADIO[$message->read] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.message.fields.chat') }}
                                    </th>
                                    <td>
                                        {{ $message->chat->chat_name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.message.fields.created_at') }}
                                    </th>
                                    <td>
                                        {{ $message->created_at }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.messages.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection