@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.hardwareType.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.hardware-types.update", [$hardwareType->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="pars">{{ trans('cruds.hardwareType.fields.pars') }}</label>
                <select class="form-control {{ $errors->has('pars') ? 'is-invalid' : '' }}" name="pars" id="pars">
                <option value="0">Disabled</option>
                <option value="1" @if( old('pars', $hardwareType->pars) ) selected=true @endif>Enabled</option>
                </select>

                @if($errors->has('pars'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pars') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.hardwareType.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $hardwareType->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.hardwareType.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="symbol">{{ trans('cruds.hardwareType.fields.symbol') }}</label>
                <input class="form-control {{ $errors->has('symbol') ? 'is-invalid' : '' }}" type="text" name="symbol" id="symbol" value="{{ old('symbol', $hardwareType->symbol) }}">
                @if($errors->has('symbol'))
                    <div class="invalid-feedback">
                        {{ $errors->first('symbol') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.hardwareType.fields.symbol_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="algoritm">{{ trans('cruds.hardwareType.fields.algoritm') }}</label>
                <input class="form-control {{ $errors->has('algoritm') ? 'is-invalid' : '' }}" type="text" name="algoritm" id="algoritm" value="{{ old('algoritm', $hardwareType->algoritm) }}">
                @if($errors->has('algoritm'))
                    <div class="invalid-feedback">
                        {{ $errors->first('algoritm') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.hardwareType.fields.algoritm_helper') }}</span>
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
