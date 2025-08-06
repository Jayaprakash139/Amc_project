@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.school.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover datatable datatable-School">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('SlNo') }}
                    </th>
                    <th>
                        {{ trans('School Id') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.mobile_number') }}
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
              @foreach($school as $key => $location)
                  <tr data-entry-id="{{ $location->id }}">
                      <td>

                      </td>
                      <td>
                          {{ ++$count }}
                      </td>
                      <td>
                        {{ $location->school_id ?? ''}}
                    </td>
                      <td>
                          {{ $location->name ?? '' }}
                      </td>
                      <td>
                          {{ $location->email ?? '' }}
                      </td>
                      <td>
                          {{ $location->mobile_number ?? '' }}
                      </td>
                     
                      <td>
                          @can('school_show')
                              <a class="btn btn-xs btn-primary" href="{{ route('admin.schools.show', $location->id) }}">
                                  {{ trans('global.view') }}
                              </a>
                          @endcan

                          @can('school_edit')
                              <a class="btn btn-xs btn-info" href="{{ route('admin.schools.edit', $location->id) }}">
                                  {{ trans('global.edit') }}
                              </a>
                          @endcan

                          @can('school_delete')
                              <form action="{{ route('admin.schools.destroy', $location->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('school_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.schools.massDestroy') }}",
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
//     ajax: "{{ route('admin.schools.index') }}",
//     columns: [
//       { data: 'placeholder', name: 'placeholder' },
// { data: 'id', name: 'id' },
// { data: 'school_id', name: 'school_id' },
// { data: 'name', name: 'name' },
// { data: 'email', name: 'email' },
// { data: 'mobile_number', name: 'mobile_number' },
// { data: 'actions', name: '{{ trans('global.actions') }}' }
//     ],
//     orderCellsTop: true,
//     order: [[ 1, 'desc' ]],
//     pageLength: 100,
//   };
//   let table = $('.datatable-School').DataTable(dtOverrideGlobals);
//   $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
//       $($.fn.dataTable.tables(true)).DataTable()
//           .columns.adjust();
//   });

$.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-School:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection