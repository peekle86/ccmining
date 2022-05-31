@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.aboutPage.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.content-pages.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.aboutPage.fields.id') }}
                        </th>
                        <td>
                            {{ $aboutPage->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.aboutPage.fields.title') }}
                        </th>
                        <td>
                            {{ $aboutPage->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.aboutPage.fields.first_text') }}
                        </th>
                        <td>
                            {!! $aboutPage->first_text !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.aboutPage.fields.second_text') }}
                        </th>
                        <td>
                            {!! $aboutPage->second_text !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.aboutPage.fields.excerpt') }}
                        </th>
                        <td>
                            {{ $aboutPage->excerpt }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.aboutPage.fields.featured_image') }}
                        </th>
                        <td>
                            @if($aboutPage->featured_image)
                                <a href="{{ $aboutPage->featured_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $aboutPage->featured_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.aboutPage.fields.language') }}
                        </th>
                        <td>
                            {{ $aboutPage->language->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.content-pages.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
