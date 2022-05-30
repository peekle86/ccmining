@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.message.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.messages.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="message">{{ trans('cruds.message.fields.message') }}</label>
                            <textarea class="form-control" name="message" id="message">{{ old('message') }}</textarea>
                            @if($errors->has('message'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('message') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.message.fields.message_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="from_id">{{ trans('cruds.message.fields.from') }}</label>
                            <select class="form-control select2" name="from_id" id="from_id" required>
                                @foreach($froms as $id => $entry)
                                    <option value="{{ $id }}" {{ old('from_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('from'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('from') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.message.fields.from_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="to_id">{{ trans('cruds.message.fields.to') }}</label>
                            <select class="form-control select2" name="to_id" id="to_id">
                                @foreach($tos as $id => $entry)
                                    <option value="{{ $id }}" {{ old('to_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('to'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('to') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.message.fields.to_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.message.fields.read') }}</label>
                            @foreach(App\Models\Message::READ_RADIO as $key => $label)
                                <div>
                                    <input type="radio" id="read_{{ $key }}" name="read" value="{{ $key }}" {{ old('read', '0') === (string) $key ? 'checked' : '' }}>
                                    <label for="read_{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('read'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('read') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.message.fields.read_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="chat_id">{{ trans('cruds.message.fields.chat') }}</label>
                            <select class="form-control select2" name="chat_id" id="chat_id" required>
                                @foreach($chats as $id => $entry)
                                    <option value="{{ $id }}" {{ old('chat_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('chat'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('chat') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.message.fields.chat_helper') }}</span>
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