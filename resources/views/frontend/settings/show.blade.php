@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.setting.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.settings.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.setting.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $setting->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.setting.fields.price_kwt') }}
                                    </th>
                                    <td>
                                        {{ $setting->price_kwt }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.setting.fields.price_mh') }}
                                    </th>
                                    <td>
                                        {{ $setting->price_mh }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.setting.fields.ref') }}
                                    </th>
                                    <td>
                                        {{ $setting->ref }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.setting.fields.active') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $setting->active ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.settings.index') }}">
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