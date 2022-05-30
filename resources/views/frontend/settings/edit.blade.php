@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.setting.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.settings.update", [$setting->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="price_kwt">{{ trans('cruds.setting.fields.price_kwt') }}</label>
                            <input class="form-control" type="number" name="price_kwt" id="price_kwt" value="{{ old('price_kwt', $setting->price_kwt) }}" step="0.01" required>
                            @if($errors->has('price_kwt'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('price_kwt') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.price_kwt_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="price_mh">{{ trans('cruds.setting.fields.price_mh') }}</label>
                            <input class="form-control" type="number" name="price_mh" id="price_mh" value="{{ old('price_mh', $setting->price_mh) }}" step="0.01" required>
                            @if($errors->has('price_mh'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('price_mh') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.price_mh_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="ref">{{ trans('cruds.setting.fields.ref') }}</label>
                            <input class="form-control" type="number" name="ref" id="ref" value="{{ old('ref', $setting->ref) }}" step="0.01">
                            @if($errors->has('ref'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ref') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.ref_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="checkbox" name="active" id="active" value="1" {{ $setting->active || old('active', 0) === 1 ? 'checked' : '' }} required>
                                <label class="required" for="active">{{ trans('cruds.setting.fields.active') }}</label>
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

        </div>
    </div>
</div>
@endsection