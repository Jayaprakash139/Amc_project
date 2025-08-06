@extends('layouts.frontend')
@section('content')
<div class="container-fluid">
@can('allocation_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('frontend.allocations.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.allocation.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Allocation', 'route' => 'admin.allocations.parseCsvImport'])
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
                        <th>
                            &nbsp;
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
   
                            {{-- <td>
                                {!! QrCode::size(50)->generate('AMS UId: ' . $assetCategory->unique_id . ', Asset Name: '.$assetCategory->asset_name . ', Asset Code: '.$assetCategory->asset_code . ', School: ' .  $assetCategory->school->name . ', Sublocation: '.$assetCategory->sublocation->name . ', Value: '.$assetCategory->value . ', Status: '.$assetCategory->status->name . ', Custody: '.$assetCategory->custody->name ?? '-' )!!}  
                                <div class="qrcode-container" id="qrcode{{ $assetCategory->id }}"></div>
                                <br>
                                <a href="#" class="download-link" data-id="{{ $assetCategory->id }}">Download</a>
                           
                            </td> --}}
                            <td>
                                {!! QrCode::size(50)->generate('AMS UId: ' . $assetCategory->unique_id . ', Asset Name: '.$assetCategory->asset_name . ', Asset Code: '.$assetCategory->asset_code . ', School: ' . optional($assetCategory->school)->name . ', Sublocation: '. optional($assetCategory->sublocation)->name . ', Value: '. $assetCategory->value . ', Status: '. optional($assetCategory->status)->name . ', Custody: '. optional($assetCategory->custody)->name ?? '-' )!!}
                                <div class="qrcode-container" id="qrcode{{ $assetCategory->id }}"></div>
                                <br>
                                <a href="#" class="download-link" data-id="{{ $assetCategory->id }}">Download</a>
                            </td>
                            
                            <td>
                                @can('allocation_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.allocations.show', $assetCategory->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                           </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
</div>
@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function() {
    @foreach($assets as $key => $assetCategory)
        (function() {
            var qrCodeData = 'AMS UID: ' +
            '{{ $assetCategory->unique_id }}' +
             ', Assets: ' +
            '{{$assetCategory->asset_name}}' +
            ', Asset Code: ' +
            '{{$assetCategory->asset_code}}' +
            ', School: ' +
            '{{$assetCategory->school->name}}' +
            ', Sublocation:' +
            '{{$assetCategory->sublocation->name}}' +
            ',  Value: ' +
            '{{$assetCategory->value}}' +
            ',  Status: ' +
            '{{$assetCategory->status->name}}' +
           
            ',Custody: ' +
            '{{$assetCategory->custody->name ?? '-'}}';

            // Generate QR code using qrious
            var qr = new QRious({
                element: document.getElementById('qrcode{{ $assetCategory->id }}'),
                value: qrCodeData,
                size: 200 // Adjust the size as needed
            });

            // Download functionality
            document.querySelector(".download-link[data-id='{{ $assetCategory->id }}']").addEventListener("click", function() {
                // Convert the QR code to a data URL
                var dataUri = qr.toDataURL();

                // Create an anchor element and trigger a click event to download the QR code
                var link = document.createElement("a");
                link.href = dataUri;
                link.download = "qrcode{{ $assetCategory->id }}.png";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
        })();
    @endforeach
});

    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('allocation_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.allocations.massDestroy') }}",
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