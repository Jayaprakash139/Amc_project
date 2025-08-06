@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} AMC Status
    </div>

    <div class="card-body">
        <a class="btn btn-default" href="{{ route('admin.amc-status-allocs.index') }}">
            {{ trans('global.back_to_list') }}
        </a>

        <table class="table table-bordered table-striped mt-3">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $amcStatusAlloc->id }}</td>
                </tr>
              
                
                <tr>
    <th>Asset</th>
    <td>{{ $amcStatusAlloc->asset->unique_id ?? '-' }} - {{ $amcStatusAlloc->asset->asset_name ?? '' }}</td>
</tr>
<tr>
    <th>School</th>
    <td>{{ $amcStatusAlloc->school_id ?? '-' }}</td>
</tr>
<tr>
    <th>Location</th>
    <td>{{ $amcStatusAlloc->location_id ?? '-' }}</td>
</tr>
<tr>
    <th>Sub Location</th>
    <td>{{ $amcStatusAlloc->sub_location_id ?? '-' }}</td>
</tr>
<tr>
    <th>Product Status</th>
    <td>{{ $amcStatusAlloc->product_status_id ?? '-' }}</td>
</tr>

<tr>
    <th>Amc Status</th>
    <td>{{ $amcStatusAlloc->amc_status_id ?? '-' }}</td>
</tr>

<tr>
    <th>AMC Date</th>
   <td>{{ $amcStatusAlloc->amc_date ? \Carbon\Carbon::parse($amcStatusAlloc->amc_date)->format('Y-m-d') : '-' }}</td>

</tr>


                <tr>
                    <th>AMC Remarks</th>
                    <td>{!! $amcStatusAlloc->amc_remarks !!}</td>
                </tr>
                <tr>
                    <th>Gallery Images</th>
                    <td>
                        <div class="row">
                            @foreach($galleryImages as $img)
                                <div class="col-md-3 mb-2">
                                    <img src="{{ asset('storage/' . $img->image) }}" style="width: 150px; height: 100px; object-fit: cover; border-radius: 4px;" class="img-thumbnail">
                                </div>
                            @endforeach
                            @if($galleryImages->isEmpty())
                                <span class="text-muted">No images found.</span>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Video</th>
                    <td>
                        @if($amcStatusAlloc->video)
                            <video width="320" height="240" controls>
                                <source src="{{ asset('storage/' . $amcStatusAlloc->video) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <span class="text-muted">No video available.</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>AMC Agent</th>
                    <td>{{ $amcStatusAlloc->amc_agent }}</td>
                </tr>
            </tbody>
        </table>

        <a class="btn btn-default mt-3" href="{{ route('admin.amc-status-allocs.index') }}">
            {{ trans('global.back_to_list') }}
        </a>
    </div>
</div>

@endsection
