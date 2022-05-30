@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.contract.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.contracts.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="amount">{{ trans('cruds.contract.fields.amount') }}</label>
                            <input class="form-control" type="number" name="amount" id="amount" value="{{ old('amount', '') }}" step="0.01" required>
                            @if($errors->has('amount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('amount') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.contract.fields.amount_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="user_id">{{ trans('cruds.contract.fields.user') }}</label>
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
                            <span class="help-block">{{ trans('cruds.contract.fields.user_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="hardware_id">{{ trans('cruds.contract.fields.hardware') }}</label>
                            <select class="form-control select2" name="hardware_id" id="hardware_id" required>
                                @foreach($hardware as $id => $entry)
                                    <option value="{{ $id }}" {{ old('hardware_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('hardware'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('hardware') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.contract.fields.hardware_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="period_id">{{ trans('cruds.contract.fields.period') }}</label>
                            <select class="form-control select2" name="period_id" id="period_id" required>
                                @foreach($periods as $id => $entry)
                                    <option value="{{ $id }}" {{ old('period_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('period'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('period') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.contract.fields.period_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="ended_at">{{ trans('cruds.contract.fields.ended_at') }}</label>
                            <input class="form-control datetime" type="text" name="ended_at" id="ended_at" value="{{ old('ended_at') }}">
                            @if($errors->has('ended_at'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ended_at') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.contract.fields.ended_at_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.contract.fields.active') }}</label>
                            @foreach(App\Models\Contract::ACTIVE_RADIO as $key => $label)
                                <div>
                                    <input type="radio" id="active_{{ $key }}" name="active" value="{{ $key }}" {{ old('active', '1') === (string) $key ? 'checked' : '' }} required>
                                    <label for="active_{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('active'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('active') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.contract.fields.active_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="percent">{{ trans('cruds.contract.fields.percent') }}</label>
                            <input class="form-control" type="number" name="percent" id="percent" value="{{ old('percent', '') }}" step="0.01">
                            @if($errors->has('percent'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('percent') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.contract.fields.percent_helper') }}</span>
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