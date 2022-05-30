@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.language.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.languages.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.language.fields.id') }}
                        </th>
                        <td>
                            {{ $language->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.language.fields.name') }}
                        </th>
                        <td>
                            {{ $language->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.language.fields.code') }}
                        </th>
                        <td>
                            {{ $language->code }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.languages.index') }}">
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
            <a class="nav-link" href="#language_faqs" role="tab" data-toggle="tab">
                {{ trans('cruds.faq.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#language_articles" role="tab" data-toggle="tab">
                {{ trans('cruds.article.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="language_faqs">
            @includeIf('admin.languages.relationships.languageFaqs', ['faqs' => $language->languageFaqs])
        </div>
        <div class="tab-pane" role="tabpanel" id="language_articles">
            @includeIf('admin.languages.relationships.languageArticles', ['articles' => $language->languageArticles])
        </div>
    </div>
</div>

@endsection