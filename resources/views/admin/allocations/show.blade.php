@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.allocation.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.allocations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    {{-- <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.id') }}
                        </th>
                        <td>
                            {{ $allocation->id }}
                        </td>
                    </tr> --}}
                    <tr>
                        <th>
                            {{ trans('AMS UID') }}
                        </th>
                        <td>
                            {{ $allocation->unique_id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.school') }}
                        </th>
                        <td>
                            {{ $allocation->school->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.sublocation') }}
                        </th>
                        <td>
                            {{ $allocation->sublocation->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.aaset_category') }}
                        </th>
                        <td>
                            {{ $allocation->aaset_category->category_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.asset_name') }}
                        </th>
                        <td>
                            {{ $allocation->asset_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.asset_code') }}
                        </th>
                        <td>
                            {{ $allocation->asset_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.description') }}
                        </th>
                        <td>
                            {!! $allocation->description ?? 'N/A' !!}
                        </td>
                    </tr>
                    {{-- <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.value') }}
                        </th>
                        <td>
                            {{ $allocation->value }}
                        </td>
                    </tr> --}}
                    <tr>
                        <th>
                            {{ trans('Product Status') }}
                        </th>
                        <td>
                            {{ $allocation->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.remark') }}
                        </th>
                        <td>
                            {!! $allocation->remark ?? 'N/A' !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.custody') }}
                        </th>
                        <td>
                            {{ $allocation->custody->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('Image') }}</th>
                        <td><img src="{{ asset('storage/'.$allocation->image) }}" width="110px" height="90px" /></td>

                    </tr>
                    <tr>
                        <th>
                            {{ trans('OR Code') }}
                        </th>  
                   
                    <td>
                        {!! QrCode::size(100)->generate('AMS UId: ' . $allocation->unique_id . ', Asset Name: '.$allocation->asset_name . ', Asset Code: '.$allocation->asset_code . ', School: ' .  $allocation->school->name . ', Sublocation: '.$allocation->sublocation->name . ', Value: '.$allocation->value . ', Status: '.$allocation->status->name . ', Custody: '.$allocation->custody->name  )!!}  
                        <div id="qrcode"></div>
                        <br>
                        <a href="#" id="downloadLink">Download</a>
                    </td>
                </tr>
                    <tr>
                        <th>
                            {{ trans('Custom Fields') }}
                        </th>
                        
                    </tr>
                   
                    <tr>
                        <th>
                            {{ trans('Name/Text-Number') }}
                        </th>
                        <td>
                            <ul>
                                @forelse ($allocation->customFields as $productDetail)
                                <li>{{ $productDetail->name }}/{{ $productDetail->text_number }}</li>
                            @empty
                                <li style="list-style: none">N/A</li>
                            @endforelse
                            
                            </ul>
                        </td>
                        
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.allocations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection

@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>

<script>

var qrCodeData =
            'AMS UID: ' +
            '{{ $allocation->unique_id }}' +
             ', Assets: ' +
            '{{$allocation->asset_name}}' +
            ', Asset Code: ' +
            '{{$allocation->asset_code}}' +
            ', School: ' +
            '{{$allocation->school->name}}' +
            ', Sublocation:' +
            '{{$allocation->sublocation->name}}' +
            ',  Value: ' +
            '{{$allocation->value}}' +
            ',  Status: ' +
            '{{$allocation->status->name}}' +
           
            ',Custody: ' +
            '{{$allocation->custody->name}}';

                       // Generate QR code using qrious
                            var qr = new QRious({
                                element: document.getElementById('qrcode'),
                                value: qrCodeData,
                                size: 200 // Adjust the size as needed
                            });
                                                // Download functionality
                            document.getElementById("downloadLink").addEventListener("click", function() {
                                // Convert the QR code to a data URL
                                var dataUri = qr.toDataURL();
                    
                                // Create an anchor element and trigger a click event to download the QR code
                                var link = document.createElement("a");
                                link.href = dataUri;
                                link.download = "qrcode.png";
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);
                            });
</script>
@endsection