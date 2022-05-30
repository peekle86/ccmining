@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.checkout.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.checkouts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.checkout.fields.id') }}
                        </th>
                        <td>
                            {{ $checkout->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.checkout.fields.user') }}
                        </th>
                        <td>
                            {{ $checkout->user->email ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('txid') }}
                        </th>
                        <td>
                            {{ $checkout->tx ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.checkout.fields.item') }}
                        </th>
                        <td>
                            @foreach($checkout->items as $key => $item)
                            <div class="d-flex justify-content-between font-xs">
                                <div class="mr-auto px-2">{{ $item->model }}</div>
                                <div class="px-2">{{ $item->pivot->percent }}%</div>
                                <div class="px-2">${{ $item->pivot->price }}</div>
                                <div>{{  $item->period($item->pivot->period_id)->period }} days</div>
                            </div>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.checkouts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
                @if( !$checkout->status )
                <form action="{{ route('admin.checkouts.aprove', $checkout->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="d-inline-block btn btn-success" value="{{ trans('Confirm') }}">
                </form>
                <div></div>
                @else
                <div class="d-inline-block text-white bg-success mb-2 py-2 px-5 font-bold">Aproved</div>
                @endif
            </div>
        </div>
    </div>
</div>



@endsection
