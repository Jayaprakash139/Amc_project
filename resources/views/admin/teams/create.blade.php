@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.team.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.teams.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.team.fields.name') }}</label>
                <select class="form-control select2 {{ $errors->has('school') ? 'is-invalid' : '' }}" name="name" id="school_id" required>
                    <option value = "">Select School</option>
                    @foreach($school as $id => $entry)
                        <option value="{{ $entry->id }}" {{ old('name') == $entry->id ? 'selected' : '' }}>{{ $entry->school_id }}/{{ $entry->name }}</option>
                    @endforeach
                </select>
                 @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.team.fields.name_helper') }}</span>
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