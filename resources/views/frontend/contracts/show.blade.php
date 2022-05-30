@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.contract.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.contracts.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.contract.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $contract->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.contract.fields.amount') }}
                                    </th>
                                    <td>
                                        {{ $contract->amount }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.contract.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $contract->user->email ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.contract.fields.hardware') }}
                                    </th>
                                    <td>
                                        {{ $contract->hardware->model ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.contract.fields.period') }}
                                    </th>
                                    <td>
                                        {{ $contract->period->period ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.contract.fields.ended_at') }}
                                    </th>
                                    <td>
                                        {{ $contract->ended_at }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.contract.fields.active') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Contract::ACTIVE_RADIO[$contract->active] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.contract.fields.percent') }}
                                    </th>
                                    <td>
                                        {{ $contract->percent }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.contract.fields.created_at') }}
                                    </th>
                                    <td>
                                        {{ $contract->created_at }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.contracts.index') }}">
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