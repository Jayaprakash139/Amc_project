@extends('layouts.admin')
@section('content')

@can('amc_status_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.amc-statuses.create') }}">
                {{ trans('global.add') }} {{ trans('AMC Status') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'AmcStatus', 'route' => 'admin.amc-statuses.parseCsvImport'])
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('AMC Status') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped table-hover datatable datatable-AmcStatus">
            <thead>
                <tr>
                    <th width="10"></th>
                    <th>{{ trans('SlNo') }}</th>
                    <th>{{ trans('cruds.status.fields.name') }}</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $count = 0; @endphp
                @foreach($amcStatuses as $amcStatus)
                    <tr data-entry-id="{{ $amcStatus->id }}">
                        <td></td>
                        <td>{{ ++$count }}</td>
                        <td>{{ $amcStatus->name ?? '' }}</td>
                        <td>
                            @can('amc_status_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.amc-statuses.show', $amcStatus->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                            @can('amc_status_edit')
                                <a class="btn btn-xs btn-info" href="{{ route('admin.amc-statuses.edit', $amcStatus->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan
                            @can('amc_status_delete')
                                <form action="{{ route('admin.amc-statuses.destroy', $amcStatus->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    @method('DELETE')
                                    @csrf
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

    @can('amc_status_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.amc-statuses.massDestroy') }}",
        className: 'btn-danger',
        action: function (e, dt, node, config) {
            let ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                return entry.id;
            });

            if (ids.length === 0) {
                alert('{{ trans('global.datatables.zero_selected') }}');
                return;
            }

            if (confirm('{{ trans('global.areYouSure') }}')) {
                $.ajax({
                    headers: {'x-csrf-token': _token},
                    method: 'POST',
                    url: config.url,
                    data: { ids: ids, _method: 'DELETE' }
                }).done(function () { location.reload() });
            }
        }
    };
    dtButtons.push(deleteButton);
    @endcan

    $.extend(true, $.fn.dataTable.defaults, {
        orderCellsTop: true,
        order: [[1, 'desc']],
        pageLength: 100,
    });

    let table = $('.datatable-AmcStatus:not(.ajaxTable)').DataTable({ buttons: dtButtons });

    $('a[data-toggle="tab"]').on('shown.bs.tab click', function() {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });
});
</script>
@endsection
