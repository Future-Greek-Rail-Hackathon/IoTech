<div class="card">
    <div class="card-header">
        {{ trans('cruds.maintenanceEvent.title_singular') }} {{ trans('global.list') }}
        @can('maintenance_event_create')
            <a class="ml-2 btn btn-success" href="{{ route('admin.maintenance-events.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.maintenanceEvent.title_singular') }}
            </a>
        @endcan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-poiMaintenanceEvents">
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
                <tbody>
                @foreach($maintenanceEvents as $key => $maintenanceEvent)
                    <tr data-entry-id="{{ $maintenanceEvent->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $maintenanceEvent->id ?? '' }}
                        </td>
                        <td>
                            {{ $maintenanceEvent->type->name ?? '' }}
                        </td>
                        <td>
                            {{ $maintenanceEvent->poi->name ?? '' }}
                        </td>
                        <td>
                            {{ App\Models\MaintenanceEvent::STATUS_SELECT[$maintenanceEvent->status] ?? '' }}
                        </td>
                        <td>
                            @foreach($maintenanceEvent->images as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                        <td>
                            @foreach($maintenanceEvent->attachments as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                        <td>
                            {{ $maintenanceEvent->assigned_to->name ?? '' }}
                        </td>
                        <td>
                            @can('maintenance_event_show')
                                <a class="btn btn-xs btn-primary"
                                   href="{{ route('admin.maintenance-events.show', $maintenanceEvent->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan

                            @can('maintenance_event_edit')
                                <a class="btn btn-xs btn-info"
                                   href="{{ route('admin.maintenance-events.edit', $maintenanceEvent->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan

                            @can('maintenance_event_delete')
                                <form
                                    action="{{ route('admin.maintenance-events.destroy', $maintenanceEvent->id) }}"
                                    method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                    style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger"
                                           value="{{ trans('global.delete') }}">
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
            @can('maintenance_event_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.maintenance-events.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({selected: true}).nodes(), function (entry) {
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
                            data: {ids: ids, _method: 'DELETE'}
                        })
                            .done(function () {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 100,
            });
            let table = $('.datatable-poiMaintenanceEvents:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection
