@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('contract_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.contracts.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.contract.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.contract.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Contract">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.contract.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.contract.fields.amount') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.contract.fields.user') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.contract.fields.hardware') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.hardwareItem.fields.hashrate') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.contract.fields.period') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.contract.fields.ended_at') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.contract.fields.active') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.contract.fields.percent') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.contract.fields.created_at') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="search">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach($users as $key => $item)
                                                <option value="{{ $item->email }}">{{ $item->email }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <select class="search">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach($hardware_items as $key => $item)
                                                <option value="{{ $item->model }}">{{ $item->model }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <select class="search">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach($contract_periods as $key => $item)
                                                <option value="{{ $item->period }}">{{ $item->period }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="search" strict="true">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach(App\Models\Contract::ACTIVE_RADIO as $key => $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contracts as $key => $contract)
                                    <tr data-entry-id="{{ $contract->id }}">
                                        <td>
                                            {{ $contract->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $contract->amount ?? '' }}
                                        </td>
                                        <td>
                                            {{ $contract->user->email ?? '' }}
                                        </td>
                                        <td>
                                            {{ $contract->user->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $contract->hardware->model ?? '' }}
                                        </td>
                                        <td>
                                            {{ $contract->hardware->hashrate ?? '' }}
                                        </td>
                                        <td>
                                            {{ $contract->period->period ?? '' }}
                                        </td>
                                        <td>
                                            {{ $contract->ended_at ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\Contract::ACTIVE_RADIO[$contract->active] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $contract->percent ?? '' }}
                                        </td>
                                        <td>
                                            {{ $contract->created_at ?? '' }}
                                        </td>
                                        <td>
                                            @can('contract_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.contracts.show', $contract->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('contract_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.contracts.edit', $contract->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('contract_delete')
                                                <form action="{{ route('frontend.contracts.destroy', $contract->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('contract_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.contracts.massDestroy') }}",
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
  let table = $('.datatable-Contract:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
})

</script>
@endsection