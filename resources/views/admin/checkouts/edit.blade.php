@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.checkout.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.checkouts.update", [$checkout->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.checkout.fields.user') }}</label>
                <input type="hidden" name="user_id" id="user_id" value="{{ $checkout->user->id }}">
                <input type="text" disabled="disabled" class="form-control" value="{{ $checkout->user->name }}">
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.checkout.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="items">{{ trans('cruds.checkout.fields.item') }}</label>

                @forelse($checkout->items as $item)
                <div class="row">
                    <div class="pl-0 p-2 col-sm-6">{{ $item->model }}</div>
                    <div class="pl-0 p-2 col-sm-2">
                        <select name="items[{{$item->id}}][percent]">
                            <option value=""></option>
                            <option value="10" @if( $item->pivot->percent == 10 ) selected @endif>10%</option>
                            <option value="20" @if( $item->pivot->percent == 20 ) selected @endif>20%</option>
                            <option value="30" @if( $item->pivot->percent == 30 ) selected @endif>30%</option>
                            <option value="40" @if( $item->pivot->percent == 40 ) selected @endif>40%</option>
                            <option value="50" @if( $item->pivot->percent == 50 ) selected @endif>50%</option>
                            <option value="60" @if( $item->pivot->percent == 60 ) selected @endif>60%</option>
                            <option value="70" @if( $item->pivot->percent == 70 ) selected @endif>70%</option>
                            <option value="80" @if( $item->pivot->percent == 80 ) selected @endif>80%</option>
                            <option value="90" @if( $item->pivot->percent == 90 ) selected @endif>90%</option>
                            <option value="100" @if( $item->pivot->percent == 100 ) selected @endif>100%</option>
                        </select>
                    </div>
                    <div class="pl-0 col-sm-2">
                        <select name="items[{{$item->id}}][period_id]" class="p-2 shadow-sm bg-white border rounded-lg">
                            @foreach ($periods as $period)
                                <option value="{{ $period->id }}" @if($period->id == $item->pivot->period_id) selected @endif >{{ $period->period }} Days</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="p-2 col-sm-2" style="width: 100px">${{ $item->pivot->price }}</div>
                    <div class="pl-0 col-sm-2">
                        <select name="items[{{$item->id}}][currency_id]" class="p-2 shadow-sm bg-white border rounded-lg">
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}" @if($currency->id == $item->pivot->currency_id) selected @endif >{{ $currency->symbol }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @empty

                @endforelse
                @if($errors->has('items'))
                    <div class="invalid-feedback">
                        {{ $errors->first('items') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.checkout.fields.item_helper') }}</span>
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
