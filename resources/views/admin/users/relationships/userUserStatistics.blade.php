@can('user_statistic_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.user-statistics.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.userStatistic.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.userStatistic.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-userUserStatistics">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.userStatistic.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.userStatistic.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.userStatistic.fields.ip') }}
                        </th>
                        <th>
                            {{ trans('cruds.userStatistic.fields.created_at') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userStatistics as $key => $userStatistic)
                        <tr data-entry-id="{{ $userStatistic->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $userStatistic->id ?? '' }}
                            </td>
                            <td>
                                {{ $userStatistic->user->email ?? '' }}
                            </td>
                            <td>
                                {{ $userStatistic->ip ?? '' }}
                            </td>
                            <td>
                                {{ $userStatistic->created_at ?? '' }}
                            </td>
                            <td>
                                @can('user_statistic_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.user-statistics.show', $userStatistic->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('user_statistic_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.user-statistics.edit', $userStatistic->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('user_statistic_delete')
                                    <form action="{{ route('admin.user-statistics.destroy', $userStatistic->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('user_statistic_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.user-statistics.massDestroy') }}",
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
  let table = $('.datatable-userUserStatistics:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection