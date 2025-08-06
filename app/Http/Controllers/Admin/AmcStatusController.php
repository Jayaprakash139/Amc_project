<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyAmcStatusRequest;
use App\Http\Requests\StoreAmcStatusRequest;
use App\Http\Requests\UpdateAmcStatusRequest;
use App\Models\AmcStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AmcStatusController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
{
    abort_if(Gate::denies('amc_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $amcStatuses = AmcStatus::all();

    return view('admin.amcStatuses.index', compact('amcStatuses'));
}


    public function create()
    {
        abort_if(Gate::denies('amc_status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.amcStatuses.create');
    }

    public function store(StoreAmcStatusRequest $request)
    {
        $amcStatus = AmcStatus::create($request->all());

        return redirect()->route('admin.amc-statuses.index');
    }

    public function edit(AmcStatus $amcStatus)
    {
        abort_if(Gate::denies('amc_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.amcStatuses.edit', compact('amcStatus'));
    }

    public function update(UpdateAmcStatusRequest $request, AmcStatus $amcStatus)
    {
        $amcStatus->update($request->all());

        return redirect()->route('admin.amc-statuses.index');
    }

    public function show(AmcStatus $amcStatus)
    {
        abort_if(Gate::denies('amc_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.amcStatuses.show', compact('amcStatus'));
    }

    public function destroy(AmcStatus $amcStatus)
    {
        abort_if(Gate::denies('amc_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $amcStatus->delete();

        return back();
    }

    public function massDestroy(MassDestroyAmcStatusRequest $request)
    {
        $amcStatuses = AmcStatus::find(request('ids'));

        foreach ($amcStatuses as $amcStatus) {
            $amcStatus->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}