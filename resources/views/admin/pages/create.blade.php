@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Create Page title
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.page.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="url">Url</label>
                <input class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" type="text" name="url" id="url" value="{{ old('url', '') }}" required>
                @if($errors->has('url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('url') }}
                    </div>
                @endif
            </div>
            @foreach($languages as $language)
                <div class="form-group">
                    <label for="title_{{ $language->id }}">Title - {{ $language->name }}</label>
                    <input class="form-control" type="text" name="title[{{ $language->id }}]" id="title_{{ $language->id }}">
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