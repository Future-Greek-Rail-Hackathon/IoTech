@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.region.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.regions.update", [$region->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.region.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $region->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.region.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="points">{{ trans('cruds.region.fields.points') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('points') ? 'is-invalid' : '' }}" name="points[]" id="points" multiple required>
                    @foreach($points as $id => $point)
                        <option value="{{ $id }}" {{ (in_array($id, old('points', [])) || $region->points->contains($id)) ? 'selected' : '' }}>{{ $point }}</option>
                    @endforeach
                </select>
                @if($errors->has('points'))
                    <span class="text-danger">{{ $errors->first('points') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.region.fields.points_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="managers">{{ trans('cruds.region.fields.managers') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('managers') ? 'is-invalid' : '' }}" name="managers[]" id="managers" multiple required>
                    @foreach($managers as $id => $manager)
                        <option value="{{ $id }}" {{ (in_array($id, old('managers', [])) || $region->managers->contains($id)) ? 'selected' : '' }}>{{ $manager }}</option>
                    @endforeach
                </select>
                @if($errors->has('managers'))
                    <span class="text-danger">{{ $errors->first('managers') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.region.fields.managers_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection