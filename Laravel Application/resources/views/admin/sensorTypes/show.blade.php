@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.sensorType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sensor-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.sensorType.fields.id') }}
                        </th>
                        <td>
                            {{ $sensorType->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sensorType.fields.name') }}
                        </th>
                        <td>
                            {{ $sensorType->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sensor-types.index') }}">
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
            <a class="nav-link" href="#type_things" role="tab" data-toggle="tab">
                {{ trans('cruds.thing.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="type_things">
            @includeIf('admin.sensorTypes.relationships.typeThings', ['things' => $sensorType->typeThings])
        </div>
    </div>
</div>

@endsection