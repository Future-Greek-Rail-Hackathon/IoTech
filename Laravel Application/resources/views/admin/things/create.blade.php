@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.thing.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.things.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="type_id">{{ trans('cruds.thing.fields.type') }}</label>
                <select class="form-control select2 {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type_id" id="type_id" required>
                    @foreach($types as $id => $entry)
                        <option value="{{ $id }}" {{ old('type_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.thing.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.thing.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.thing.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="eui">{{ trans('cruds.thing.fields.eui') }}</label>
                <input class="form-control {{ $errors->has('eui') ? 'is-invalid' : '' }}" type="text" name="eui" id="eui" value="{{ old('eui', '') }}" required>
                @if($errors->has('eui'))
                    <span class="text-danger">{{ $errors->first('eui') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.thing.fields.eui_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="installed_at">{{ trans('cruds.thing.fields.installed_at') }}</label>
                <input class="form-control date {{ $errors->has('installed_at') ? 'is-invalid' : '' }}" type="text" name="installed_at" id="installed_at" value="{{ old('installed_at') }}">
                @if($errors->has('installed_at'))
                    <span class="text-danger">{{ $errors->first('installed_at') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.thing.fields.installed_at_helper') }}</span>
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