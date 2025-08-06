s<div class="m-3">
    @can('allocation_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.allocations.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.allocation.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.allocation.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-schoolAllocations">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('SlNo') }}
                            </th>
                            <th>
                                {{ trans('AMS UId') }}
                            </th>

                            <th>
                                {{ trans('cruds.allocation.fields.school') }}
                            </th>
                            <th>
                                {{ trans('cruds.allocation.fields.sublocation') }}
                            </th>
                            <th>
                                {{ trans('cruds.allocation.fields.aaset_category') }}
                            </th>
                            <th>
                                {{ trans('cruds.allocation.fields.asset_name') }}
                            </th>
                            <th>
                                {{ trans('cruds.allocation.fields.asset_code') }}
                            </th>
                            <th>
                                {{ trans('cruds.allocation.fields.value') }}
                            </th>
                            <th>
                                {{ trans('cruds.allocation.fields.status') }}
                            </th>
                            <th>
                                {{ trans('cruds.allocation.fields.custody') }}
                            </th>
                            <th>
                                {{ trans('Image') }}
                            </th>
                            <th>
                                {{ trans('Qr Code') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count=0; ?>
                        @foreach($allocations as $key => $allocation)
                            <tr data-entry-id="{{ $allocation->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ ++$count }}
                                </td>
                                <td>
                                    {{ $allocation->unique_id ?? '' }}
                                </td>

                                <td>
                                    {{ $allocation->school->name ?? '' }}
                                </td>
                                <td>
                                    {{ $allocation->sublocation->name ?? '' }}
                                </td>
                                <td>
                                    {{ $allocation->aaset_category->category_name ?? '' }}
                                </td>
                                <td>
                                    {{ $allocation->asset_name ?? '' }}
                                </td>
                                <td>
                                    {{ $allocation->asset_code ?? '' }}
                                </td>
                                <td>
                                    {{ $allocation->value ?? '' }}
                                </td>
                                <td>
                                    {{ $allocation->status->name ?? '' }}
                                </td>
                                <td>
                                    {{ $allocation->custody->name ?? '' }}
                                </td>
                                <td><img src="{{ asset('storage/'.$allocation->image) }}" width="90px" height="70px" /></td>
   
                        
                                <td>
                                    {!! QrCode::size(80)->generate('AMS UId: ' . $allocation->unique_id . ', Asset Name: '.$allocation->asset_name . ', Asset Code: '.$allocation->asset_code . ', School: ' .  $allocation->school->name . ', Sublocation: '.$allocation->sublocation->name . ', Value: '.$allocation->value . ', Status: '.$allocation->status->name . ', Custody: '.$allocation->custody->name  )!!}  
                                    <div class="qrcode-container" id="qrcode{{ $allocation->id }}"></div>
                                    <br>
                                    <a href="#" class="download-link" data-id="{{ $allocation->id }}">Download</a>
                               
                                </td>
                                <td>
                                    @can('allocation_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.allocations.show', $allocation->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('allocation_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.allocations.edit', $allocation->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('allocation_delete')
                                        <form action="{{ route('admin.allocations.destroy', $allocation->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>

<script>


                            document.addEventListener("DOMContentLoaded", function() {
    @foreach($allocations as $key => $allocation)
        (function() {
            var qrCodeData = 'AMS UID: ' +
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
                element: document.getElementById('qrcode{{ $allocation->id }}'),
                value: qrCodeData,
                size: 200 // Adjust the size as needed
            });

            // Download functionality
            document.querySelector(".download-link[data-id='{{ $allocation->id }}']").addEventListener("click", function() {
                // Convert the QR code to a data URL
                var dataUri = qr.toDataURL();

                // Create an anchor element and trigger a click event to download the QR code
                var link = document.createElement("a");
                link.href = dataUri;
                link.download = "qrcode{{ $allocation->id }}.png";
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
  let table = $('.datatable-schoolAllocations:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection