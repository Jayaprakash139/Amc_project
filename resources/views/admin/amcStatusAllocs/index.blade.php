@extends('layouts.admin')
@section('content')
@can('amc_status_alloc_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.amc-status-allocs.create') }}">
                {{ trans('global.add') }} {{ trans('AMC Status') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'AmcStatusAlloc', 'route' => 'admin.amc-status-allocs.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('AMC Status') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-AmcStatusAlloc">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('id') }}
                    </th>
                    <th>
                        {{ trans('Asset') }}
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
                        {{ trans('Amc Status') }}
                    </th>
                    <th>
                        {{ trans('Amc Date') }}
                    </th>
                    <th>
                        {{ trans('Amc Remarks') }}
                    </th>
                  
                    <th>
                        {{ trans('Amc Agent') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('amc_status_alloc_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.amc-status-allocs.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.amc-status-allocs.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'asset', name: 'asset' },
{ data: 'school_id', name: 'school_id' },
{ data: 'location_id', name: 'location_id' },
{ data: 'sub_location_id', name: 'sub_location_id' },
{ data: 'product_status_id', name: 'product_status_id' },
 { data: 'amc_status_id', name: 'amc_status_id' }, 
{ data: 'amc_date', name: 'amc_date' },
{ data: 'amc_remarks', name: 'amc_remarks' },

{ data: 'amc_agent', name: 'amc_agent' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-AmcStatusAlloc').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection