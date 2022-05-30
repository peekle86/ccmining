@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.currency.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.currencies.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.currency.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.currency.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="symbol">{{ trans('cruds.currency.fields.symbol') }}</label>
                <input class="form-control {{ $errors->has('symbol') ? 'is-invalid' : '' }}" type="text" name="symbol" id="symbol" value="{{ old('symbol', '') }}">
                @if($errors->has('symbol'))
                    <div class="invalid-feedback">
                        {{ $errors->first('symbol') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.currency.fields.symbol_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="in_usd">{{ trans('cruds.currency.fields.in_usd') }}</label>
                <input class="form-control {{ $errors->has('in_usd') ? 'is-invalid' : '' }}" type="number" name="in_usd" id="in_usd" value="{{ old('in_usd', '') }}" step="0.01">
                @if($errors->has('in_usd'))
                    <div class="invalid-feedback">
                        {{ $errors->first('in_usd') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.currency.fields.in_usd_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="min_withdrawal">{{ trans('cruds.currency.fields.min_withdrawal') }}</label>
                <input class="form-control {{ $errors->has('min_withdrawal') ? 'is-invalid' : '' }}" type="text" name="min_withdrawal" id="min_withdrawal" value="{{ old('min_withdrawal', '') }}">
                @if($errors->has('min_withdrawal'))
                    <div class="invalid-feedback">
                        {{ $errors->first('min_withdrawal') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.currency.fields.min_withdrawal_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('active') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="active" value="0">
                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ old('active', 0) == 1 || old('active') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">{{ trans('cruds.currency.fields.active') }}</label>
                </div>
                @if($errors->has('active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.currency.fields.active_helper') }}</span>
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