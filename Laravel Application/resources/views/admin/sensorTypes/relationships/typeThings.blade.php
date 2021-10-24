<div class="m-3">
    @can('thing_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.things.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.thing.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.thing.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-typeThings">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.thing.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.thing.fields.type') }}
                            </th>
                            <th>
                                {{ trans('cruds.thing.fields.name') }}
                            </th>
                            <th>
                                {{ trans('cruds.thing.fields.eui') }}
                            </th>
                            <th>
                                {{ trans('cruds.thing.fields.installed_at') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($things as $key => $thing)
                            <tr data-entry-id="{{ $thing->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $thing->id ?? '' }}
                                </td>
                                <td>
                                    {{ $thing->type->name ?? '' }}
                                </td>
                                <td>
                                    {{ $thing->name ?? '' }}
                                </td>
                                <td>
                                    {{ $thing->eui ?? '' }}
                                </td>
                                <td>
                                    {{ $thing->installed_at ?? '' }}
                                </td>
                                <td>
                                    @can('thing_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.things.show', $thing->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('thing_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.things.edit', $thing->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('thing_delete')
                                        <form action="{{ route('admin.things.destroy', $thing->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('thing_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.things.massDestroy') }}",
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
  let table = $('.datatable-typeThings:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection