@extends('layouts.admin')
@section('content')


<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-4 mt-4" style="font-size: 20px;">
                {{ trans('Allocation') }} {{ trans('Reports') }}
            </div>
    
            <form method="POST" action="{{ route('admin.allocation.filter') }}" class="col-md-8 row">
                @csrf
                <div class="col-md-3">
                    <label for="start_date">{{ trans('Start Date') }}</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date', old('start_date', '')) }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date">{{ trans('End Date') }}</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date', old('end_date', '')) }}">
                </div>
                <div class="col-md-3">
                    <label for="school">{{ trans('School') }}</label>
                    <select class="form-control select2 {{ $errors->has('school') ? 'is-invalid' : '' }}" name="school" id="school" required>
                        @foreach($schools as $id => $entry)
                            <option value="{{ $id }}" {{ request('school', old('school', '')) == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mt-4">
                    <label>&nbsp;</label>
                    <button class="btn btn-primary">{{ trans('Filter') }}</button>
                </div>
            </form>
             
        </div>
    </div>
 
    

    
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Allocation">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('SlNo') }}
                        </th>
                       
                        <th>
                            {{ trans('AMS U.Id') }}
                        </th>
                        <th>
                            {{ trans('Asset Code') }}
                        </th>
                        <th>
                            {{ trans('Asset Category') }}
                        </th>
                        <th>
                            {{ trans('Asset Name') }}
                        </th>
                        <th>
                            {{ trans('School Name') }}
                        </th>
                       
                        <th>
                            {{ trans('Location') }}
                        </th>
                        <th>
                            {{ trans('Value') }}
                        </th>
                        <th>
                            {{ trans('Status') }}
                        </th>
                        <th>
                            {{ trans('Custody') }}
                        </th>
                        <th>
                            {{ trans('Image') }}
                        </th>
                        <th>
                            {{ trans('QR Code') }}
                        </th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $count=0;
                    ?>
                    @foreach($assets as $key => $assetCategory)
                        <tr data-entry-id="{{ $assetCategory->id }}">
                            <td>
                               
                            </td>
                            <td>
                                {{ ++$count }}
                            </td>
                            <td>
                            
                                {{ $assetCategory->unique_id ?? '' }}
                            </td>
                            <td>
                            
                                {{ $assetCategory->asset_code ?? '' }}
                            </td>
                            <td>
                                {{ $assetCategory->aaset_category->category_name ?? '' }}
                            </td>
                            <td>
                                {{ $assetCategory->asset_name ?? '' }}
                                
                            </td>
                            <td>
                                {{ $assetCategory->school->name ?? '' }}
                            </td>
                            
                            <td>
                                {{ $assetCategory->sublocation->name ?? '' }}
                             
                            </td>
                            <td>
                                {{ $assetCategory->value ?? '' }}
                             
                            </td>
                            <td>
                                {{ $assetCategory->status->name ?? '' }}
                            </td>
                            <td>
                                {{ $assetCategory->custody->name ?? '' }}
                            </td>
                            <td><img src="{{ asset('storage/'.$assetCategory->image) }}" width="90px" height="70px" /></td>
   
                             {{-- QR Code --}}

                                <td style="text-align: center;">
                                    <!-- Add canvas with the correct ID -->
                                    <div style="border: 1px solid black;" class="p-2">
                                        <canvas class="qrcode-container" id="qrcode{{ $assetCategory->id }}"
                                            style="height:70px;width:70px;"></canvas>

                                        <br>
                                        <p style="font-size:12px; margin-bottom: 0px !important;">
                                            {{ $assetCategory->unique_id ?? '' }}</p>
                                        <p style="font-size:12px;margin-bottom: 1px !important;">
                                            {{ Str::limit($assetCategory->asset_name ?? '', 22, '') }}</p>

                                    </div>

                                    <a href="#" class="download-link" data-id="{{ $assetCategory->id }}">Download</a>
                                </td>
                       {{-- QR Code --}}


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>

<script>



 document.addEventListener("DOMContentLoaded", function() {
    @foreach ($assets as $assetCategory)
        (function() {
            const assetId = '{{ $assetCategory->id }}';
            const uniqueId = '{{ $assetCategory->unique_id ?? '' }}';
            const assetName = '{{ Str::limit($assetCategory->asset_name ?? '', 18, '') }}';
            const fullName = '{{ $assetCategory->asset_name ?? '' }}';
            const assetCode = '{{ $assetCategory->asset_code ?? '' }}';
            const schoolName = '{{ $assetCategory->school->name ?? '' }}';
            const sublocationName = '{{ $assetCategory->sublocation->name ?? '' }}';
            const value = '{{ $assetCategory->value ?? '' }}';
            const statusName = '{{ $assetCategory->status->name ?? '' }}';
            const custodyName = '{{ $assetCategory->custody->name ?? '' }}';

            // Full QR data
            const qrCodeData =
                `AMS UID: ${uniqueId}, Assets: ${fullName}, Asset Code: ${assetCode}, School: ${schoolName}, Sublocation: ${sublocationName}, Value: ${value}, Status: ${statusName}, Custody: ${custodyName}`;

            // Generate QR code using QRious
            new QRious({
                element: document.getElementById('qrcode' + assetId),
                value: qrCodeData,
                size: 260,
                level: 'H',
                backgroundAlpha: 0 // Transparent background
            });

            // Download logic
            const downloadBtn = document.querySelector(".download-link[data-id='" + assetId + "']");
            if (downloadBtn) {
                downloadBtn.addEventListener("click", function(e) {
                    e.preventDefault();

                    const qrCanvas = document.getElementById('qrcode' + assetId);
                    const qrDataUrl = qrCanvas.toDataURL();

                    const qrImg = new Image();
                    

                    
                   
qrImg.onload = function() {
    const scaleFactor = 4; // High-res scaling factor
    const qrSize = 62; // QR Code size (original dimensions)
    const padding = 5;
    const borderRadius = 12;
    const labelWidth = 170;
    const labelHeight = 70;

    // Create high-resolution canvas
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    // Set high-res dimensions (scaled for better clarity)
    canvas.width = labelWidth * scaleFactor;
    canvas.height = labelHeight * scaleFactor;
    ctx.scale(scaleFactor, scaleFactor); // Apply scaling for crisp rendering

    // Draw rounded border
    ctx.fillStyle = "#fff";
    ctx.strokeStyle = "#b4b4b4";
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.roundRect(0, 0, labelWidth, labelHeight, borderRadius);
    ctx.fill();
    ctx.stroke();

    // Draw QR code in correct position
    const qrX = padding;
    const qrY = padding;
    ctx.drawImage(qrImg, qrX, qrY, qrSize, qrSize);

    // **Text Formatting Fixes**
    ctx.fillStyle = "#000";
    ctx.textAlign = "left";

    // Define font sizes separately (fixed size instead of scaled)
    ctx.font = "bold 7px Arial";

    // **School Name Fix**
    const maxSchoolChars = 30; // Allow more characters for better readability
    const schoolText = schoolName.length > maxSchoolChars ? schoolName.substring(0, maxSchoolChars) + '...' : schoolName;
    ctx.fillText(schoolText, qrX + qrSize + 15, qrY + 12);

    // **UID Fix**
    ctx.font = "bold 7px Arial"; // Keep UID slightly smaller but clear
    ctx.fillText(uniqueId, qrX + qrSize + 15, qrY + 28);

    // **Asset Name Fix**
    ctx.font = "normal 6px Arial"; // Ensure readable font weight
    ctx.fillText(assetName, qrX + qrSize + 15, qrY + 45);

    // **Download in HD Quality**
    const finalImage = canvas.toDataURL("image/png", 1.0); // Ensure max quality PNG
    const link = document.createElement("a");
    link.href = finalImage;
    link.download = "qr_" + uniqueId + ".png";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};




                    qrImg.src = qrDataUrl;
                });
            }
        })();
    @endforeach
});

 

    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('allocation_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.allocations.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Allocation:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})


</script>
@endsection