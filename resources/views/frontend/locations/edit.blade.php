@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.location.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.locations.update", [$location->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="school_id">{{ trans('cruds.location.fields.school') }}</label>
                            <select class="form-control select2" name="school_id" id="school_id" required>
                                @foreach($schools as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('school_id') ? old('school_id') : $location->school->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('school'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('school') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.location.fields.school_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.location.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $location->name) }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.location.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection