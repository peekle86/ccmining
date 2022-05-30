@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.setting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.settings.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="price_kwt">{{ trans('cruds.setting.fields.price_kwt') }}</label>
                <input class="form-control {{ $errors->has('price_kwt') ? 'is-invalid' : '' }}" type="number" name="price_kwt" id="price_kwt" value="{{ old('price_kwt', '') }}" step="0.01" required>
                @if($errors->has('price_kwt'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price_kwt') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.setting.fields.price_kwt_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="price_th">{{ trans('cruds.setting.fields.price_th') }}</label>
                <input class="form-control {{ $errors->has('price_th') ? 'is-invalid' : '' }}" type="number" name="price_th" id="price_th" value="{{ old('price_th', '') }}" step="0.0001" required>
                @if($errors->has('price_th'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price_th') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.setting.fields.price_th_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="profit_th">{{ trans('cruds.setting.fields.profit_th') }}</label>
                <input class="form-control {{ $errors->has('profit_th') ? 'is-invalid' : '' }}" type="number" name="profit_th" id="profit_th" value="{{ old('profit_th', '') }}" step="0.0001" required>
                @if($errors->has('profit_th'))
                    <div class="invalid-feedback">
                        {{ $errors->first('profit_th') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.setting.fields.profit_th_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="max_th">{{ trans('cruds.setting.fields.max_th') }}</label>
                <input class="form-control {{ $errors->has('max_th') ? 'is-invalid' : '' }}" type="number" name="max_th" id="max_th" value="{{ old('max_th', '') }}" step="0.0001" required>
                @if($errors->has('max_th'))
                    <div class="invalid-feedback">
                        {{ $errors->first('max_th') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.setting.fields.max_th_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ref">{{ trans('cruds.setting.fields.ref') }}</label>
                <input class="form-control {{ $errors->has('ref') ? 'is-invalid' : '' }}" type="number" name="ref" id="ref" value="{{ old('ref', '') }}" step="0.01">
                @if($errors->has('ref'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ref') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.setting.fields.ref_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('active') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" required {{ old('active', 0) == 1 || old('active') === null ? 'checked' : '' }}>
                    <label class="required form-check-label" for="active">{{ trans('cruds.setting.fields.active') }}</label>
                </div>
                @if($errors->has('active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.setting.fields.active_helper') }}</span>
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
