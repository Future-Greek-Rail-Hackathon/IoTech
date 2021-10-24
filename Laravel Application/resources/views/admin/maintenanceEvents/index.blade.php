@extends('layouts.admin')
@section('content')
@can('maintenance_event_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.maintenance-events.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.maintenanceEvent.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.maintenanceEvent.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-MaintenanceEvent">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.maintenanceEvent.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.maintenanceEvent.fields.type') }}
                    </th>
                    <th>
                        {{ trans('cruds.maintenanceEvent.fields.poi') }}
                    </th>
                    <th>
                        {{ trans('cruds.maintenanceEvent.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.maintenanceEvent.fields.images') }}
                    </th>
                    <th>
                        {{ trans('cruds.maintenanceEvent.fields.attachments') }}
                    </th>
                    <th>
                        {{ trans('cruds.maintenanceEvent.fields.assigned_to') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('maintenance_event_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.maintenance-events.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.maintenance-events.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'type_name', name: 'type.name' },
{ data: 'poi_name', name: 'poi.name' },
{ data: 'status', name: 'status' },
{ data: 'images', name: 'images', sortable: false, searchable: false },
{ data: 'attachments', name: 'attachments', sortable: false, searchable: false },
{ data: 'assigned_to_name', name: 'assigned_to.name' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-MaintenanceEvent').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection