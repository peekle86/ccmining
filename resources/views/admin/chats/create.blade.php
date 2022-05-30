@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.chat.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.chats.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.chat.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.chat.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="chat_name">{{ trans('cruds.chat.fields.chat_name') }}</label>
                <input class="form-control {{ $errors->has('chat_name') ? 'is-invalid' : '' }}" type="text" name="chat_name" id="chat_name" value="{{ old('chat_name', '') }}">
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



@endsection