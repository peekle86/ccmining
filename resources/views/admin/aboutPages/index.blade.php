@extends('layouts.admin')
@section('content')
@can('content_page_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.about-page.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.aboutPage.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.aboutPage.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ContentPage">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.aboutPage.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.aboutPage.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.aboutPage.fields.excerpt') }}
                        </th>
                        <th>
                            {{ trans('cruds.aboutPage.fields.featured_image') }}
                        </th>
                        <th>
                            {{ trans('cruds.aboutPage.fields.language') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aboutPages as $key => $aboutPage)
                        <tr data-entry-id="{{ $aboutPage->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $aboutPage->id ?? '' }}
                            </td>
                            <td>
                                {{ $aboutPage->title ?? '' }}
                            </td>
                            <td>
                                {{ $aboutPage->excerpt ?? '' }}
                            </td>
                            <td>
                                @if($aboutPage->featured_image)
                                    <a href="{{ $aboutPage->featured_image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $aboutPage->featured_image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $aboutPage->language->name ?? '' }}
                            </td>
                            <td>
                                @can('content_page_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.about-page.show', $aboutPage->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('content_page_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.about-page.edit', $aboutPage->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('content_page_delete')
                                    <form action="{{ route('admin.about-page.destroy', $aboutPage->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('content_page_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.about-page.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-ContentPage:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
