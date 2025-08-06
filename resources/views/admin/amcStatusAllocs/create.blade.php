@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('AMC Status') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.amc-status-allocs.store") }}" enctype="multipart/form-data">
            @csrf
           
            <div class="form-group">
                <label for="asset_id">{{ trans('Asset') }}</label>
                <select name="asset_id" id="asset_id" class="form-control {{ $errors->has('asset_id') ? 'is-invalid' : '' }}">
                    <option value="">{{ trans('global.pleaseSelect') }}</option>
                    @foreach($assets as $asset)
                        <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                            {{ $asset->unique_id }} - {{ $asset->asset_name }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('asset_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('asset_id') }}
                    </div>
                @endif
            </div>


            <div class="form-group">
                <label for="school_name">{{ trans('School Name') }}</label>
                <input class="form-control {{ $errors->has('school_name') ? 'is-invalid' : '' }}" type="text" name="school_id" id="school_name" value="{{ old('school_id', '') }}" readonly>
                @if($errors->has('school_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('school_name') }}
                    </div>
                @endif
              
            </div>
            <div class="form-group">
                <label for="location">{{ trans('Location') }}</label>
                <input class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" type="text" name="location_id" id="location" value="{{ old('location_id', '') }}" readonly>
                @if($errors->has('location'))
                    <div class="invalid-feedback">
                        {{ $errors->first('location') }}
                    </div>
                @endif
              
            </div>
            <div class="form-group">
                <label for="sub_location">{{ trans('Sub Location') }}</label>
                <input class="form-control {{ $errors->has('sub_location') ? 'is-invalid' : '' }}" type="text" name="sub_location_id" id="sub_location" value="{{ old('sub_location_id', '') }}" readonly>
                @if($errors->has('sub_location'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sub_location') }}
                    </div>
                @endif
              
            </div>

            <div class="form-group">
                <label for="product_status">{{ trans('Product Status') }}</label>
                <input class="form-control {{ $errors->has('product_status') ? 'is-invalid' : '' }}" type="text" name="product_status_id" id="product_status" value="{{ old('product_status_id', '') }}" readonly>
                @if($errors->has('product_status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('product_status') }}
                    </div>
                @endif
            </div>

              <div class="form-group">
                <label for="product_status">{{ trans('AMC Status') }}</label>
                <input class="form-control {{ $errors->has('product_status') ? 'is-invalid' : '' }}" type="text" name="amc_status_id" id="amc_status" value="{{ old('amc_status_id', '') }}" readonly>
                @if($errors->has('product_status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('product_status') }}
                    </div>
                @endif
            </div>
             
            <div class="form-group">
                <label for="amc_date">{{ trans('Amc Date') }}</label>
            
                                <input 
                    class="form-control  {{ $errors->has('amc_date') ? 'is-invalid' : '' }}" 
                    type="date" 
                    name="amc_date" 
                    id="amc_date" 
                    value="{{ old('amc_date') ?? now()->format(config('panel.date_format')) }}"
                    autocomplete="off"
               readonly >


                @if($errors->has('amc_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amc_date') }}
                    </div>
                @endif
              
            </div>
            

            <div class="form-group">
    <label for="amc_remarks">{{ trans('Amc Remarks') }}</label>
    <textarea class="form-control ckeditor {{ $errors->has('amc_remarks') ? 'is-invalid' : '' }}" name="amc_remarks" id="amc_remarks">{{ old('amc_remarks', '') }}</textarea>
    @if($errors->has('amc_remarks'))
        <div class="invalid-feedback">
            {{ $errors->first('amc_remarks') }}
        </div>
    @endif
</div>


        
             {{-- <-----------------twenty two gallery images-----------------> --}}

            <label class="required" for="status">Gallery </label>
            <input type="file" class="form-control" id="imageInput" name="amc_multi_gallery[]" multiple accept="image/*">
            <div id="preview" class=="m-2"></div>

            {{-- <-----------------twenty two gallery images-----------------> --}}


         <div class="form-group">
    <label for="video">{{ trans('Video') }}</label>
    <input class="form-control {{ $errors->has('video') ? 'is-invalid' : '' }}" type="file" name="video" id="video" accept="video/*">
    @if($errors->has('video'))
        <div class="invalid-feedback">
            {{ $errors->first('video') }}
        </div>
    @endif
</div>



            <div class="form-group">
                <label for="amc_agent">{{ trans('Amc Agent') }}</label>
                <input class="form-control {{ $errors->has('amc_agent') ? 'is-invalid' : '' }}" type="text" name="amc_agent" id="amc_agent" value="{{ old('amc_agent', '') }}">
                @if($errors->has('amc_agent'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amc_agent') }}
                    </div>
                @endif
               
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
@parent

<script>
    flatpickr(".date", {
        dateFormat: "d-m-Y"
    });
</script>



<script>
    $('#asset_id').on('change', function () {
        var assetId = $(this).val();

        if (assetId) {
            $.ajax({
                url: '{{ route("admin.get-asset-details") }}',
                type: 'GET',
                data: { asset_id: assetId },
                success: function (data) {
                    $('#school_name').val(data.school_name);
                    $('#location').val(data.location_name);
                    $('#sub_location').val(data.sub_location_name);
                    $('#product_status').val(data.status_name);
                    $('#amc_date').val(data.amc_date);
                     $('#amc_status').val(data.amc_status);
                },
                error: function () {
                    alert('Failed to fetch asset details');
                }
            });
        } else {
            $('#school_name, #location, #sub_location, #product_status, #amc_date').val('');
        }
    });
</script>



{{-- Gallery image --}}

<script>
    document.getElementById('imageInput').addEventListener('change', function(event) {
   const preview = document.getElementById('preview');
   preview.innerHTML = '';  // Clear previous previews

   const files = event.target.files;

   if (files.length > 0) {
       Array.from(files).forEach(file => {
           if (file.type.startsWith('image/')) {
               const reader = new FileReader();
               
               reader.onload = function(e) {
                   const img = document.createElement('img');
                   img.src = e.target.result;

                   img.style.width = '100px';  // Set image width
                   img.style.height = '100px';  // Set image height
                   img.style.objectFit = 'cover';  // Keep aspect ratio
                   img.style.borderRadius = '5px';  // Optional: Rounded corners
                   img.style.margin = '5px';  // Optional: Margin between images

                   preview.appendChild(img);
               }
               
               reader.readAsDataURL(file);
           }
       });
   }
});

document.getElementById('imageUploadForm').addEventListener('submit', function(event) {
   event.preventDefault();
   const formData = new FormData(this);
   
   // You can now send the form data using AJAX or any other method to the backend
   console.log('Form submitted with images:', formData.getAll('images[]'));
   
   // Example: Sending form data using fetch
   // fetch('your-backend-url', {
   //     method: 'POST',
   //     body: formData
   // }).then(response => {
   //     // Handle response
   // });
});

</script>

{{-- Gallery image --}}




<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#amc_remarks'))
        .catch(error => {
            console.error(error);
        });
</script>



@endsection
