@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.hardwareItem.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.hardware-items.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.hardwareItem.fields.id') }}
                        </th>
                        <td>
                            {{ $hardwareItem->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.hardwareItem.fields.price') }}
                        </th>
                        <td>
                            {{ $hardwareItem->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.hardwareItem.fields.model') }}
                        </th>
                        <td>
                            {{ $hardwareItem->model }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.hardwareItem.fields.hashrate') }}
                        </th>
                        <td>
                            {{ $hardwareItem->hashrate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.hardwareItem.fields.power') }}
                        </th>
                        <td>
                            {{ $hardwareItem->power }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.hardwareItem.fields.algoritm') }}
                        </th>
                        <td>
                            {{ $hardwareItem->algoritm->algoritm ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.hardwareItem.fields.profitability') }}
                        </th>
                        <td>
                            {{ $hardwareItem->profitability }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.hardwareItem.fields.available') }}
                        </th>
                        <td>
                            {{ App\Models\HardwareItem::AVAILABLE_RADIO[$hardwareItem->available] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.hardwareItem.fields.photo') }}
                        </th>
                        <td>
                            @if($hardwareItem->photo)
                                <a href="{{ $hardwareItem->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $hardwareItem->photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.hardwareItem.fields.description') }}
                        </th>
                        <td>
                            {{ $hardwareItem->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.hardwareItem.fields.specification') }}
                        </th>
                        <td>
                            {{ $hardwareItem->specification }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.hardwareItem.fields.coins') }}
                        </th>
                        <td>
                            {{ $hardwareItem->coins }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.hardwareItem.fields.script') }}
                        </th>
                        <td>
                            {{ $hardwareItem->script }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.hardwareItem.fields.url') }}
                        </th>
                        <td>
                            {{ $hardwareItem->url }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.hardware-items.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
