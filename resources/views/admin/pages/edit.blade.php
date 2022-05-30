@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} Page title
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.page.update",$pages->first()->id ) }}" enctype="multipart/form-data">
            @method("put")
            @csrf
            <div class="form-group">
                <label class="required" for="url">Url</label>
                <input class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" type="text" name="url" id="url" value="{{ $pages->first()->url }}" required>
                @if($errors->has('url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('url') }}
                    </div>
                @endif
            </div>
            @foreach($languages as $language)
                <div class="form-group">
                    <label for="title_{{ $language->id }}">Title - {{ $language->name }}</label>
                    <input value="{{ $pages->where("language_id",$language->id)->first()->title }}" class="form-control" type="text" name="title[{{ $language->id }}]" id="title_{{ $language->id }}">
                </div>

                <div class="form-group">
                    <label for="description_{{ $language->id }}">Description - {{ $language->name }}</label>
                    <textarea class="form-control" name="description[{{ $language->id }}]" id="description_{{ $language->id }}">{!! $pages->where("language_id",$language->id)->first()->description !!}</textarea>
                </div>
            @endforeach
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
