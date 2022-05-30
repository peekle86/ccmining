@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.walletNetwork.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.wallet-networks.update", [$walletNetwork->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.walletNetwork.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $walletNetwork->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.walletNetwork.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="symbol">{{ trans('cruds.walletNetwork.fields.symbol') }}</label>
                <input class="form-control {{ $errors->has('symbol') ? 'is-invalid' : '' }}" type="text" name="symbol" id="symbol" value="{{ old('symbol', $walletNetwork->symbol) }}">
                @if($errors->has('symbol'))
                    <div class="invalid-feedback">
                        {{ $errors->first('symbol') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.walletNetwork.fields.symbol_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="coingecko">{{ trans('cruds.walletNetwork.fields.coingecko') }}</label>
                <input class="form-control {{ $errors->has('coingecko') ? 'is-invalid' : '' }}" type="text" name="coingecko" id="coingecko" value="{{ old('coingecko', $walletNetwork->coingecko) }}">
                @if($errors->has('coingecko'))
                    <div class="invalid-feedback">
                        {{ $errors->first('coingecko') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.walletNetwork.fields.coingecko_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="in_usd">{{ trans('cruds.walletNetwork.fields.in_usd') }}</label>
                <input class="form-control {{ $errors->has('in_usd') ? 'is-invalid' : '' }}" type="text" name="in_usd" id="in_usd" value="{{ old('in_usd', $walletNetwork->in_usd) }}">
                @if($errors->has('in_usd'))
                    <div class="invalid-feedback">
                        {{ $errors->first('in_usd') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.walletNetwork.fields.in_usd_helper') }}</span>
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
