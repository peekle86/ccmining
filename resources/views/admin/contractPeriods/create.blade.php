@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.contractPeriod.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.contract-periods.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="period">{{ trans('cruds.contractPeriod.fields.period') }}</label>
                <input class="form-control {{ $errors->has('period') ? 'is-invalid' : '' }}" type="number" name="period" id="period" value="{{ old('period', '') }}" step="1" required>
                @if($errors->has('period'))
                    <div class="invalid-feedback">
                        {{ $errors->first('period') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contractPeriod.fields.period_helper') }}</span>
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