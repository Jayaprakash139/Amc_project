@extends('layouts.admin')
@section('content')
@can('department_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.departments.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.department.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Department', 'route' => 'admin.departments.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.department.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover datatable datatable-Department">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('SlNo') }}
                    </th>
                    <th>
                        {{ trans('Role') }}
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
                @foreach($locations as $key => $location)
                    <tr data-entry-id="{{ $location->id }}">
                        <td>

                        </td>
                        <td>
                            {{ ++$count }}
                        </td>
                       
                        <td>
                            {{ $location->role ?? '' }}
                        </td>
                        <td>
                            @can('department_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.departments.show', $location->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan

                            @can('department_edit')
                                <a class="btn btn-xs btn-info" href="{{ route('admin.departments.edit', $location->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan

                            @can('department_delete')
                                <form action="{{ route('admin.departments.destroy', $location->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('department_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.departments.massDestroy') }}",
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

//   let dtOverrideGlobals = {
//     buttons: dtButtons,
//     processing: true,
//     serverSide: true,
//     retrieve: true,
//     aaSorting: [],
//     ajax: "{{ route('admin.departments.index') }}",
//     columns: [
//       { data: 'placeholder', name: 'placeholder' },
// { data: 'id', name: 'id' },
// { data: 'role', name: 'role' },
// { data: 'actions', name: '{{ trans('global.actions') }}' }
//     ],
//     orderCellsTop: true,
//     order: [[ 1, 'desc' ]],
//     pageLength: 100,
//   };
//   let table = $('.datatable-Department').DataTable(dtOverrideGlobals);
//   $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
//       $($.fn.dataTable.tables(true)).DataTable()
//           .columns.adjust();
//   });


$.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Department:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection