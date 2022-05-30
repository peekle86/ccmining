@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.wallet.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.wallets.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="address">{{ trans('cruds.wallet.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', '') }}" required>
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.wallet.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.wallet.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.wallet.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="amount">{{ trans('cruds.wallet.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="text" name="amount" id="amount" value="{{ old('amount', '') }}">
                @if($errors->has('amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.wallet.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="network_id">{{ trans('cruds.wallet.fields.network') }}</label>
                <select class="form-control select2 {{ $errors->has('network') ? 'is-invalid' : '' }}" name="network_id" id="network_id" required>
                    @foreach($networks as $id => $entry)
                        <option value="{{ $id }}" {{ old('network_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('network'))
                    <div class="invalid-feedback">
                        {{ $errors->first('network') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.wallet.fields.network_helper') }}</span>
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