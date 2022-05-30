@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.chat.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.chats.update", [$chat->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="user_id">{{ trans('cruds.chat.fields.user') }}</label>
                            <select class="form-control select2" name="user_id" id="user_id" required>
                                @foreach($users as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $chat->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('user') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.chat.fields.user_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="name">{{ trans('cruds.chat.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $chat->name) }}">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.chat.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="chat_name">{{ trans('cruds.chat.fields.chat_name') }}</label>
                            <input class="form-control" type="text" name="chat_name" id="chat_name" value="{{ old('chat_name', $chat->chat_name) }}">
                            @if($errors->has('chat_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('chat_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.chat.fields.chat_name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection