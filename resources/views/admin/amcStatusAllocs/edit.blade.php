@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('AMC Status') }}
    </div>

    <div class="card-body">
        

     
        <form method="POST" action="{{ route('admin.amc-status-allocs.update', $amcStatusAlloc->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Asset (using ID) --}}
    <div class="form-group">
        <label for="asset_id">Asset</label>
        <select name="asset_id" id="asset_id" class="form-control">
            <option value="">-- Select Asset --</option>
            @foreach($assets as $asset)
                <option value="{{ $asset->id }}" {{ old('asset_id', $amcStatusAlloc->asset_id) == $asset->id ? 'selected' : '' }}>
                    {{ $asset->unique_id }} - {{ $asset->asset_name }}
                </option>
            @endforeach
        </select>
    </div>

   

    {{-- School Name (auto-filled) --}}
<div class="form-group">
    <label for="school_name">School</label>
    <input type="text" name="school_id" id="school_id" class="form-control" 
        value="{{ old('school_name', $amcStatusAlloc->school_id) }}" readonly>
</div>

{{-- Location --}}
<div class="form-group">
    <label for="location">Location</label>
    <input type="text" name="location_id" id="location" class="form-control" 
        value="{{ old('location', $amcStatusAlloc->location_id) }}" readonly>
</div>

{{-- Sub Location --}}
<div class="form-group">
    <label for="sub_location">Sub Location</label>
    <input type="text" name="sub_location_id" id="sub_location" class="form-control" 
        value="{{ old('sub_location', $amcStatusAlloc->sub_location_id) }}" readonly>
</div>

{{-- Product Status --}}
<div class="form-group">
    <label for="product_status">Product Status</label>
    <input type="text" name="product_status_id" id="product_status" class="form-control" 
        value="{{ old('product_status', $amcStatusAlloc->product_status_id) }}" readonly>
</div>

{{-- Amc Status --}}
<div class="form-group">
    <label for="product_status">Amc Status</label>
    <input type="text" name="amc_status_id" id="amc_status" class="form-control" 
        value="{{ old('product_status', $amcStatusAlloc->amc_status_id) }}" readonly>
</div>


{{-- AMC Date --}}
<div class="form-group">
    <label for="amc_date">AMC Date</label>
    <input type="date" name="amc_date" id="amc_date" class="form-control" 
        value="{{ old('amc_date', \Carbon\Carbon::parse($amcStatusAlloc->amc_date)->format('Y-m-d')) }}" readonly>
</div>




    {{-- AMC Remarks --}}
    <div class="form-group">
        <label for="amc_remarks">AMC Remarks</label>
        <textarea name="amc_remarks" id="amc_remarks" class="form-control ckeditor">
            {!! old('amc_remarks', $amcStatusAlloc->amc_remarks) !!}
        </textarea>
    </div>

    {{-- Video --}}
    <div class="form-group">
        <label for="video">Video</label>
        <input type="file" name="video" id="video" class="form-control" accept="video/*">
        @if($amcStatusAlloc->video)
            <p class="mt-2">Current: <a href="{{ asset('storage/'.$amcStatusAlloc->video) }}" target="_blank">View Video</a></p>
        @endif
    </div>

    {{-- Agent --}}
    <div class="form-group">
        <label for="amc_agent">AMC Agent</label>
        <input type="text" name="amc_agent" id="amc_agent" value="{{ old('amc_agent', $amcStatusAlloc->amc_agent) }}" class="form-control">
    </div>

    {{-- Gallery Images --}}
    <div class="form-group">
        <label>Gallery Images</label>
        <input type="file" name="amc_multi_gallery[]" class="form-control" id="imageInput" multiple accept="image/*">
        <div class="row mt-3">
            @foreach($galleryImages ?? [] as $img)
                <div class="col-md-3 imgcol{{ $img->id }}">
               <img width="140px" height="130px" src="{{ asset('storage/'.$img->image) }}">

                    <button type="button" class="btn btn-sm btn-danger delete-item" data-image-id="{{ $img->id }}">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>





    </div>
</div>



@endsection

@section('scripts')
@parent



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
                     $('#amc_status').val(data.amc_status);
                    $('#amc_date').val(data.amc_date);
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


 {{-- gallery images --}}

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
                   img.style.height = '150px';  // Set image height
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

 {{-- gallery images --}}




<script>

    

// {{-- <-----dynamic delete item sweat alerts------> --}}
    $(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Event handler for delete button click
    $('body').on('click', '.delete-item', function(event){
        event.preventDefault();

        // Get the image ID
        let _img_id = $(this).data('image-id');

        // Construct the delete URL dynamically
        let deleteUrl = "{{route('admin.multi-image.destroy',':id')}}".replace(':id', _img_id);

        // Show SweetAlert confirmation dialog
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Make the DELETE request via AJAX
                $.ajax({
                    type: "DELETE",
                    url: deleteUrl,
                    success: function(data){
                        if (data.status == 'success') {
                            Swal.fire(
                                "Deleted!",
                                data.message,
                                "success"
                            );
                            // Remove the image from the DOM
                            $(".imgcol" + _img_id).remove();
                        } else {
                            Swal.fire(
                                "Error!",
                                "There was an error deleting the image.",
                                "error"
                            );
                        }
                    },
                    error: function(xhr, status, error){
                        Swal.fire(
                            "Error!",
                            "Something went wrong. Please try again.",
                            "error"
                        );
                    }
                });
            }
        });
    });
});

</script>





<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#amc_remarks'))
        .catch(error => {
            console.error(error);
        });
</script>





@endsection