@extends('layouts.admin')
@section('content')
    @can('allocation_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.allocations.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.allocation.title_singular') }}
                </a>
                <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans('global.app_csvImport') }}
                </button>
                @include('csvImport.modal', [
                    'model' => 'Allocation',
                    'route' => 'admin.allocations.parseCsvImport',
                ])
            </div>
        </div>
    @endcan

    <div class="card">
        <div class="card-header">
            {{ trans('Allocation') }} {{ trans('global.list') }}
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
                                {{ trans('Sub Location') }}
                            </th>
                            <th>
                                {{ trans('Product Status') }}
                            </th>
                            <th>
                                {{ trans('AMC Status') }}
                            </th>

                            <th>
                                {{ trans('AMC Updated On') }}
                            </th>


                            <th>
                                {{ trans('Custody') }}
                            </th>
                            <th>
                                {{ trans('Image') }}
                            </th>
                            
                            <th>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        ?>
                        @foreach ($assets as $key => $assetCategory)
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
                                    {{ $assetCategory->location->name ?? '' }}
                                </td>

                                <td>
                                    {{ $assetCategory->sublocation->sub_location ?? '' }}
                                </td>

                                <td>
                                    {{ $assetCategory->status->name ?? '' }}
                                </td>

                                <td>
                                    
                                {{ $assetCategory->amcStatus->name ?? 'Not Set' }}
                                        
                                    </td>
                                    <td>
                                         {{ $assetCategory->amcStatus->created_at ?? '' }}
                                    </td>


                                <td>
                                    {{ $assetCategory->custody->name ?? '' }}
                                </td>
                                <td><img src="{{ asset('storage/' . $assetCategory->image) }}" width="90px"
                                        height="70px" /></td>




                                <td>
                                    @can('allocation_show')
                                        <a class="btn btn-xs btn-primary"
                                            href="{{ route('admin.allocations.show', $assetCategory->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('allocation_edit')
                                        <a class="btn btn-xs btn-info"
                                            href="{{ route('admin.allocations.edit', $assetCategory->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('allocation_delete')
                                        <form action="{{ route('admin.allocations.destroy', $assetCategory->id) }}"
                                            method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger"
                                                value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

                                  <button type="button" class="btn btn-xs btn-warning"
                                    data-toggle="modal"
                                    data-target="#changeAmcStatusModal{{ $assetCategory->id }}">
                                    Change AMC Status
                                </button>


                                </td>

                            </tr>


                            
     <!-- Modal -->
<div class="modal fade" id="changeAmcStatusModal{{ $assetCategory->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $assetCategory->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('admin.allocations.updateAmcStatus', $assetCategory->id) }}">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel{{ $assetCategory->id }}">Change AMC Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="amc_status_id_{{ $assetCategory->id }}">Select Status</label>
                        <select name="amc_status_id" id="amc_status_id_{{ $assetCategory->id }}" class="form-control" required>
                            <option value="">Select Option</option>
                            @foreach(\App\Models\AmcStatus::all() as $status)
                                <option value="{{ $status->id }}" {{ $assetCategory->amc_status_id == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Status</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>







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

     {{--  --}}

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
    const qrSize = 63; // QR Code size (original dimensions)
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




        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('allocation_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.allocations.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            let table = $('.datatable-Allocation:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection





{{-- document.querySelector(".download-link[data-id='{{ $assetCategory->id }}']").addEventListener("click", function() {
                // Convert the QR code to a data URL
                var dataUri = qr.toDataURL();

                // Create an anchor element and trigger a click event to download the QR code
                var link = document.createElement("a");
                link.href = dataUri;
                link.download = "qrcode{{ $assetCategory->id }}.png";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }); --}}
