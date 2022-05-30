@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.currency.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.currencies.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.currency.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $currency->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.currency.fields.name') }}
                                    </th>
                                    <td>
                                        {{ $currency->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.currency.fields.symbol') }}
                                    </th>
                                    <td>
                                        {{ $currency->symbol }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.currency.fields.in_usd') }}
                                    </th>
                                    <td>
                                        {{ $currency->in_usd }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.currency.fields.min_withdrawal') }}
                                    </th>
                                    <td>
                                        {{ $currency->min_withdrawal }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.currency.fields.active') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $currency->active ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.currencies.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection