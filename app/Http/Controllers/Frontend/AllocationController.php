<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAllocationRequest;
use App\Http\Requests\StoreAllocationRequest;
use App\Http\Requests\UpdateAllocationRequest;
use App\Models\Allocation;
use App\Models\Category;
use App\Models\Customfield;
use App\Models\Employee;
use App\Models\Location;
use App\Models\School;
use App\Models\Status;
use Gate;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AllocationController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('allocation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

     
        $assets = Allocation::with(['school', 'aaset_category','status','custody','sublocation'])->get();

        return view('frontend.allocations.index', compact('assets'));
    }

    public function create()
    {
        abort_if(Gate::denies('allocation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schools = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sublocations = Location::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $aaset_categories = Category::pluck('category_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = Status::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $custodies = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.allocations.create', compact('aaset_categories', 'custodies', 'schools', 'statuses', 'sublocations'));
    }

    public function store(StoreAllocationRequest $request)
    {
        //dd($request->all());
        $allocation = Allocation::create($request->all());
        $allocation->unique_id = IdGenerator::generate(['table' => 'allocations', 'field' => 'unique_id', 'length' => 10, 'prefix' => 'AALID']);

        if ($request->hasFile('image')) {
            $file = $request->file('image')->store('allotImage', 'public');
            $allocation->image = $file;
        }
        
        // Save the allocation record
        $allocation->save();
      
        $assets = $request->name;
        $locations = $request->serial_no;
       
    
        
        if (!empty($assets)) {
            foreach ($assets as $key => $assetId) {
                $dataToSave = [
                    'allot_id' => $allocation->unique_id,
                    'name' => $assetId,
                    'text_number' => $locations[$key] ?? null,
                ];
                Customfield::create($dataToSave);
            }
        }
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $allocation->id]);
        }


        return redirect()->route('frontend.allocations.index');
    }

    public function edit(Allocation $allocation)
    {
        abort_if(Gate::denies('allocation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schools = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sublocations = Location::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $aaset_categories = Category::pluck('category_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = Status::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $custodies = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $allocation->load('school', 'sublocation', 'aaset_category', 'status', 'custody', 'team');

        return view('frontend.allocations.edit', compact('aaset_categories', 'allocation', 'custodies', 'schools', 'statuses', 'sublocations'));
    }

    public function update(UpdateAllocationRequest $request, Allocation $allocation)
    {
        $allocation->update($request->all());
        if($request->hasFile('image')){
            $img = $request->file('image')->store('allotImage','public');
            $allocation->image = $img;
        }
        $allocation->save();
    
        if (!empty($request->customFields_ids)) {
            foreach ($request->customFields_ids as $count => $productDetailId) {
                DB::table('customfields')->where('id', $productDetailId)->delete();
            }
        }
        
        if (!empty($request->name)) {
            foreach ($request->name as $count => $assetId) {
                $dataToSave = [
                    'allot_id' => $request->unique_id,
                    'name' => $assetId,
                    'text_number' => $request->serial_no[$count] ?? null,
                ];
                Customfield::create($dataToSave);
            }
        }
        return redirect()->route('frontend.allocations.index');
    }

    public function show(Allocation $allocation)
    {
        abort_if(Gate::denies('allocation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allocation->load('school', 'sublocation', 'aaset_category', 'status', 'custody', 'team','customFields');

        return view('frontend.allocations.show', compact('allocation'));
    }

    public function destroy(Allocation $allocation)
    {
        abort_if(Gate::denies('allocation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allocation->delete();

        return back();
    }

    public function massDestroy(MassDestroyAllocationRequest $request)
    {
        $allocations = Allocation::find(request('ids'));

        foreach ($allocations as $allocation) {
            $allocation->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('allocation_create') && Gate::denies('allocation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Allocation();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
