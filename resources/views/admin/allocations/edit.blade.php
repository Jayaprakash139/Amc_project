@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.allocation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.allocations.update", [$allocation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <input type="hidden" name="unique_id" value="{{ $allocation->unique_id }}">
            <div class="form-group">
                <label class="required" for="school_id">{{ trans('cruds.allocation.fields.school') }}</label>
                <select class="form-control select2 {{ $errors->has('school') ? 'is-invalid' : '' }}" name="school_id" id="school_id" required>
                    @foreach($schools as $id => $entry)
                        <option value="{{ $id }}" {{ (old('school_id') ? old('school_id') : $allocation->school->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('school'))
                    <span class="text-danger">{{ $errors->first('school') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.school_helper') }}</span>
            </div>


            <div class="form-group">
                <label class="required" for="location_id">{{ trans('Location') }}</label>
               
               <select class="form-control select2" name="location_id" id="location_id" required>
                @foreach($locations as $id => $entry)
                    <option value="{{ $id }}" {{ (old('location_id') ?? $allocation->location_id) == $id ? 'selected' : '' }}>{{ $entry }}</option>
                @endforeach
            </select>



                @if($errors->has('sublocation'))
                    <span class="text-danger">{{ $errors->first('sublocation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.sublocation_helper') }}</span>
            </div>

    
            <div class="form-group">
                <label class="required" for="sublocation_id">{{ trans('Sub Location') }}</label>
                <select class="form-control select2 {{ $errors->has('sublocation') ? 'is-invalid' : '' }}" name="sublocation_id" id="sublocation_id" required>
                    <option value="">-- Please Select --</option>
                </select>

                @if($errors->has('sublocation'))
                    <span class="text-danger">{{ $errors->first('sublocation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.sublocation_helper') }}</span>
            </div>


            <div class="form-group">
                <label for="aaset_category_id">{{ trans('cruds.allocation.fields.aaset_category') }}</label>
                <select class="form-control select2 {{ $errors->has('aaset_category') ? 'is-invalid' : '' }}" name="aaset_category_id" id="aaset_category_id">
                    @foreach($aaset_categories as $id => $entry)
                        <option value="{{ $id }}" {{ (old('aaset_category_id') ? old('aaset_category_id') : $allocation->aaset_category->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('aaset_category'))
                    <span class="text-danger">{{ $errors->first('aaset_category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.aaset_category_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="asset_name">{{ trans('cruds.allocation.fields.asset_name') }}</label>
                <input class="form-control {{ $errors->has('asset_name') ? 'is-invalid' : '' }}" type="text" name="asset_name" id="asset_name" value="{{ old('asset_name', $allocation->asset_name) }}" required>
                @if($errors->has('asset_name'))
                    <span class="text-danger">{{ $errors->first('asset_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.asset_name_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="asset_code">{{ trans('cruds.allocation.fields.asset_code') }}</label>
                <input class="form-control {{ $errors->has('asset_code') ? 'is-invalid' : '' }}" type="text" name="asset_code" id="asset_code" value="{{ old('asset_code', $allocation->asset_code) }}" required>
                @if($errors->has('asset_code'))
                    <span class="text-danger">{{ $errors->first('asset_code') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.asset_code_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="description">{{ trans('cruds.allocation.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $allocation->description) !!}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.description_helper') }}</span>
            </div>
          
            <div class="form-group">
                <label class="required" for="status_id">{{ trans('Product Status') }}</label>
                <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status_id" id="status_id" required>
                    @foreach($statuses as $id => $entry)
                        <option value="{{ $id }}" {{ (old('status_id') ? old('status_id') : $allocation->status->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.allocation.fields.remark') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{!! old('remark', $allocation->remark) !!}</textarea>
                @if($errors->has('remark'))
                    <span class="text-danger">{{ $errors->first('remark') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.remark_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="custody_id">{{ trans('cruds.allocation.fields.custody') }}</label>
                <select class="form-control select2 {{ $errors->has('custody') ? 'is-invalid' : '' }}" name="custody_id" id="custody_id" required>
                    @foreach($custodies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('custody_id') ? old('custody_id') : $allocation->custody->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('custody'))
                    <span class="text-danger">{{ $errors->first('custody') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.custody_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="value">{{ trans('Old Image') }}</label>
                <img src="{{ asset('storage/'.$allocation->image) }}" width="120px" height="120px" />
            </div>
            <div class="form-group">
                <label for="value">{{ trans(' NewImage') }}</label>
                <input class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" type="file" name="image" id="image">
                @if($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.value_helper') }}</span>
            </div>
            <div class="boxs mt-4">
                <input onclick="addFields()" type="button" class="btn btn-primary" value="Add Custom Fields"> 
                <div id="container" class="mt-2">
                @if($allocation->customFields)
                   
                    @foreach($allocation->customFields as $customField)
                        
                            <div class="field-container row">
                                <input type="hidden" name="customFields_ids[]" value="{{ $customField->id }}">
                                <div class="col-md-3 mb-2">
                                    <label for="name{{ $customField->id }}">Name</label>
                                    <input type="text" class="form-control" name="name[]" id="name{{ $customField->id }}" value="{{ $customField->name }}" placeholder="Name">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label for="serial_no{{ $customField->id }}">Text/Number</label>
                                    <input type="text" class="form-control" name="serial_no[]" id="serial_no{{ $customField->id }}" value="{{ $customField->text_number }}" placeholder="Text/Number">
                                </div>
                                <div class="col-md-3 mt-4 mb-2">
                                  
                                    <input type="button" value="+" class="btn btn-success mr-2" onclick="addFields()">
                                    <input type="button" value="-" class="btn btn-danger" onclick="removeFields(this)">
                                </div>
                            </div>
                        
                    @endforeach
                @endif
            </div>
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

@section('scripts')
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.allocations.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $allocation->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});

let fieldIndex = 0;

function addFields() {
  fieldIndex++;

  const container = document.getElementById('container');

  const fieldContainer = document.createElement('div');
  fieldContainer.classList.add('field-container', 'row');

  const col1 = document.createElement('div');
  col1.classList.add('col-md-3', 'mb-2');
  const input1 = document.createElement('input');
  input1.type = 'text';
  input1.className = 'form-control';
  input1.name = `name[]`;
  input1.placeholder = 'Name';
  col1.appendChild(input1);

  const col2 = document.createElement('div');
  col2.classList.add('col-md-3', 'mb-2');
  const input2 = document.createElement('input');
  input2.type = 'text';
  input2.className = 'form-control';
  input2.name = `serial_no[]`;
  input2.placeholder = 'Text/Number';
  col2.appendChild(input2);

  const col3 = document.createElement('div');
  col3.classList.add('col-md-2', 'mb-2');

  const plusButton = document.createElement('input');
plusButton.type = 'button';
plusButton.value = '+';
plusButton.className = 'btn btn-success mr-2';
plusButton.onclick = addFields;
col3.appendChild(plusButton);

const minusButton = document.createElement('input');
minusButton.type = 'button';
minusButton.value = '-';
minusButton.className = 'btn btn-danger';
minusButton.onclick = function() {
  removeFields(this);
};
col3.appendChild(minusButton);

  fieldContainer.appendChild(col1);
  fieldContainer.appendChild(col2);
  fieldContainer.appendChild(col3);

  container.appendChild(fieldContainer);
}

function removeFields(element) {
  const fieldContainer = element.parentNode.parentNode;
  fieldContainer.parentNode.removeChild(fieldContainer);
}

</script>



<script>
    $(document).ready(function () {
        function loadSublocations(locationId, selectedId = null) {
            if (locationId) {
                $.ajax({
                    url: '{{ url("admin/get-sublocations") }}/' + locationId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#sublocation_id').empty().append('<option value="">-- Please Select --</option>');
                        $.each(data, function (key, value) {
                            let selected = (key == selectedId) ? 'selected' : '';
                            $('#sublocation_id').append('<option value="' + key + '" ' + selected + '>' + value + '</option>');
                        });
                    }
                });
            } else {
                $('#sublocation_id').html('<option value="">-- Please Select --</option>');
            }
        }

        // Initial load
        const currentLocationId = $('#location_id').val();
        const currentSublocationId = "{{ old('sublocation_id') ?? ($allocation->sublocation_id ?? '') }}";

        if (currentLocationId) {
            loadSublocations(currentLocationId, currentSublocationId);
        }

        // On location change
        $('#location_id').on('change', function () {
            let locationId = $(this).val();
            loadSublocations(locationId, null); // Clear sublocation selection
        });
    });
</script>



@endsection