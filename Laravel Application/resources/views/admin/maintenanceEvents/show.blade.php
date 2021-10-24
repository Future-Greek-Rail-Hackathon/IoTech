@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.maintenanceEvent.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.maintenance-events.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.maintenanceEvent.fields.id') }}
                        </th>
                        <td>
                            {{ $maintenanceEvent->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.maintenanceEvent.fields.type') }}
                        </th>
                        <td>
                            {{ $maintenanceEvent->type->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.maintenanceEvent.fields.poi') }}
                        </th>
                        <td>
                            {{ $maintenanceEvent->poi->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.maintenanceEvent.fields.latitude') }}
                        </th>
                        <td>
                            {{ $maintenanceEvent->latitude }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.maintenanceEvent.fields.longitude') }}
                        </th>
                        <td>
                            {{ $maintenanceEvent->longitude }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.maintenanceEvent.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\MaintenanceEvent::STATUS_SELECT[$maintenanceEvent->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.maintenanceEvent.fields.description') }}
                        </th>
                        <td>
                            {!! $maintenanceEvent->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.maintenanceEvent.fields.images') }}
                        </th>
                        <td>
                            @foreach($maintenanceEvent->images as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.maintenanceEvent.fields.attachments') }}
                        </th>
                        <td>
                            @foreach($maintenanceEvent->attachments as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.maintenanceEvent.fields.assigned_to') }}
                        </th>
                        <td>
                            {{ $maintenanceEvent->assigned_to->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.maintenance-events.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection