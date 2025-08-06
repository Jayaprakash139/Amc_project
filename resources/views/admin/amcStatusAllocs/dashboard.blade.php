@extends('layouts.admin')

<style>
    .card h5 {
        font-size: 1.1rem;
    }

    .card-footer {
        font-size: 10px;
    }

    .card-title{
        font-size:8px !important;

        margin-bottom: 5px !important;

    }
    .assetcode{
        font-size: 12px !important;
        
    }
    .assetcode p{
        padding: 0px !important;
    }

    p {
    margin-top: 0;
    margin-bottom: 0rem !important;
}
</style>


@section('content')





<div class="card">
    <div class="card-header">
        <h4>AMS Status Dashboard</h4>
    </div>

    <form method="GET" class="mb-3 p-3">
    <div class="row">
        <div class="col-md-4">
            <label for="location_id">Location</label>
            <select name="location_id" id="location_id" class="form-control">
                <option value="">-- All Locations --</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                        {{ $location->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="sublocation_id">Sub Location</label>
            <select name="sublocation_id" id="sublocation_id" class="form-control">
                <option value="">-- All Sub Locations --</option>
                @foreach($sublocations as $sublocation)
                    <option value="{{ $sublocation->id }}" {{ request('sublocation_id') == $sublocation->id ? 'selected' : '' }}>
                        {{ $sublocation->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary mr-2">Filter</button>
            <a href="{{ route('admin.ams_status_dash.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </div>
</form>



    <div class="card-body">
       

        <div class="row">
    @if($allocations->count())
        @foreach($allocations as $allocation)
            <div class="col-md-2">
                <div class="card mb-3">
                  
                    <div class="card-body">
                        <h5 class="card-title">Asset Name : <strong>{{ Str::limit($allocation->asset_name, 18) }}</strong></h5>
                        <p class="assetcode">Asset Code :  <strong>{{ $allocation->unique_id }}</strong></p>
                    </div>
                    <div class="card-footer text-white"
                        style="background-color: {{ in_array($allocation->id, $amcAllocatedAssetIds) ? '#28a745' : '#dc3545' }}">
                        <strong>AMC Status:</strong>
                       {{ Str::limit($allocation->amcStatus->name ?? 'Not Set', 11) }}

                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-12">
            <div class="alert alert-info text-center">
                No Matched Items.
            </div>
        </div>
    @endif
</div>



    </div>
</div>
@endsection



                        