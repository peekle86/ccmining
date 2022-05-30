@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.transaction.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.transactions.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="user_id">{{ trans('cruds.transaction.fields.user') }}</label>
                            <select class="form-control select2" name="user_id" id="user_id" required>
                                @foreach($users as $id => $entry)
                                    <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('user') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.transaction.fields.user_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.transaction.fields.type') }}</label>
                            @foreach(App\Models\Transaction::TYPE_RADIO as $key => $label)
                                <div>
                                    <input type="radio" id="type_{{ $key }}" name="type" value="{{ $key }}" {{ old('type', '') === (string) $key ? 'checked' : '' }} required>
                                    <label for="type_{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.transaction.fields.type_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="amount">{{ trans('cruds.transaction.fields.amount') }}</label>
                            <input class="form-control" type="text" name="amount" id="amount" value="{{ old('amount', '') }}" required>
                            @if($errors->has('amount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('amount') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.transaction.fields.amount_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.transaction.fields.status') }}</label>
                            @foreach(App\Models\Transaction::STATUS_RADIO as $key => $label)
                                <div>
                                    <input type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}" {{ old('status', '0') === (string) $key ? 'checked' : '' }} required>
                                    <label for="status_{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.transaction.fields.status_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="contract_id">{{ trans('cruds.transaction.fields.contract') }}</label>
                            <select class="form-control select2" name="contract_id" id="contract_id">
                                @foreach($contracts as $id => $entry)
                                    <option value="{{ $id }}" {{ old('contract_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('contract'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('contract') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.transaction.fields.contract_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="currency_id">{{ trans('cruds.transaction.fields.currency') }}</label>
                            <select class="form-control select2" name="currency_id" id="currency_id" required>
                                @foreach($currencies as $id => $entry)
                                    <option value="{{ $id }}" {{ old('currency_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('currency'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('currency') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.transaction.fields.currency_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="source">{{ trans('cruds.transaction.fields.source') }}</label>
                            <input class="form-control" type="text" name="source" id="source" value="{{ old('source', '') }}">
                            @if($errors->has('source'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('source') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.transaction.fields.source_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="target">{{ trans('cruds.transaction.fields.target') }}</label>
                            <input class="form-control" type="text" name="target" id="target" value="{{ old('target', '') }}">
                            @if($errors->has('target'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('target') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.transaction.fields.target_helper') }}</span>
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