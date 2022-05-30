@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.wallet.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.wallets.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.wallet.fields.id') }}
                        </th>
                        <td>
                            {{ $wallet->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.wallet.fields.address') }}
                        </th>
                        <td>
                            {{ $wallet->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.wallet.fields.user') }}
                        </th>
                        <td>
                            {{ $wallet->user->email ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.wallet.fields.amount') }}
                        </th>
                        <td>
                            {{ $wallet->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.wallet.fields.network') }}
                        </th>
                        <td>
                            {{ $wallet->network->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.wallets.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#wallet_users" role="tab" data-toggle="tab">
                {{ trans('cruds.user.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="wallet_users">
            @includeIf('admin.wallets.relationships.walletUsers', ['users' => $wallet->walletUsers])
        </div>
    </div>
</div>

@endsection