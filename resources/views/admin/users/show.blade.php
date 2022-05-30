@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.user.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.id') }}
                        </th>
                        <td>
                            {{ $user->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <td>
                            {{ $user->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <td>
                            {{ $user->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.email_verified_at') }}
                        </th>
                        <td>
                            {{ $user->email_verified_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.verified') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $user->verified ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.roles') }}
                        </th>
                        <td>
                            @foreach($user->roles as $key => $roles)
                                <span class="label label-info">{{ $roles->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.avatar') }}
                        </th>
                        <td>
                            @if($user->avatar)
                                <a href="{{ $user->avatar->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $user->avatar->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.ref') }}
                        </th>
                        <td>
                            {{ $user->ref }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.parent') }}
                        </th>
                        <td>
                            {{ $user->parent->email ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.ref_percent') }}
                        </th>
                        <td>
                            {{ $user->ref_percent }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.wallet') }}
                        </th>
                        <td>
                            {{ $user->wallet->address ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.created_at') }}
                        </th>
                        <td>
                            {{ $user->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.users.index') }}">
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
            <a class="nav-link" href="#user_balances" role="tab" data-toggle="tab">
                {{ trans('cruds.balance.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_contracts" role="tab" data-toggle="tab">
                {{ trans('cruds.contract.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_user_statistics" role="tab" data-toggle="tab">
                {{ trans('cruds.userStatistic.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_chats" role="tab" data-toggle="tab">
                {{ trans('cruds.chat.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_carts" role="tab" data-toggle="tab">
                {{ trans('cruds.cart.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_wallets" role="tab" data-toggle="tab">
                {{ trans('cruds.wallet.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_checkouts" role="tab" data-toggle="tab">
                {{ trans('cruds.checkout.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="user_balances">
            @includeIf('admin.users.relationships.userBalances', ['balances' => $user->userBalances])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_contracts">
            @includeIf('admin.users.relationships.userContracts', ['contracts' => $user->userContracts])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_user_statistics">
            @includeIf('admin.users.relationships.userUserStatistics', ['userStatistics' => $user->userUserStatistics])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_chats">
            @includeIf('admin.users.relationships.userChats', ['chats' => $user->userChats])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_carts">
            @includeIf('admin.users.relationships.userCarts', ['carts' => $user->userCarts])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_wallets">
            @includeIf('admin.users.relationships.userWallets', ['wallets' => $user->userWallets])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_checkouts">
            @includeIf('admin.users.relationships.userCheckouts', ['checkouts' => $user->checkouts])
        </div>
    </div>
</div>

@endsection
