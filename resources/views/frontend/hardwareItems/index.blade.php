@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('hardware_item_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.hardware-items.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.hardwareItem.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.hardwareItem.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-HardwareItem">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.hardwareItem.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.hardwareItem.fields.model') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.hardwareItem.fields.hashrate') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.hardwareItem.fields.power') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.hardwareItem.fields.algoritm') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.hardwareItem.fields.profitability') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.hardwareItem.fields.available') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.hardwareItem.fields.photo') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.hardwareItem.fields.url') }}
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
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="search">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach($hardware_types as $key => $item)
                                                <option value="{{ $item->algoritm }}">{{ $item->algoritm }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="search" strict="true">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach(App\Models\HardwareItem::AVAILABLE_RADIO as $key => $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hardwareItems as $key => $hardwareItem)
                                    <tr data-entry-id="{{ $hardwareItem->id }}">
                                        <td>
                                            {{ $hardwareItem->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $hardwareItem->model ?? '' }}
                                        </td>
                                        <td>
                                            {{ $hardwareItem->hashrate ?? '' }}
                                        </td>
                                        <td>
                                            {{ $hardwareItem->power ?? '' }}
                                        </td>
                                        <td>
                                            {{ $hardwareItem->algoritm->algoritm ?? '' }}
                                        </td>
                                        <td>
                                            {{ $hardwareItem->profitability ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\HardwareItem::AVAILABLE_RADIO[$hardwareItem->available] ?? '' }}
                                        </td>
                                        <td>
                                            @if($hardwareItem->photo)
                                                <a href="{{ $hardwareItem->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $hardwareItem->photo->getUrl('thumb') }}">
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $hardwareItem->url ?? '' }}
                                        </td>
                                        <td>
                                            @can('hardware_item_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.hardware-items.show', $hardwareItem->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('hardware_item_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.hardware-items.edit', $hardwareItem->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('hardware_item_delete')
                                                <form action="{{ route('frontend.hardware-items.destroy', $hardwareItem->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('hardware_item_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.hardware-items.massDestroy') }}",
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
  let table = $('.datatable-HardwareItem:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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