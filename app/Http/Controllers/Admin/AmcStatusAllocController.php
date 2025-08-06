<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyAmcStatusAllocRequest;
use App\Http\Requests\StoreAmcStatusAllocRequest;
use App\Http\Requests\UpdateAmcStatusAllocRequest;
use App\Models\Allocation;
use App\Models\AmcgalleryImage;
use App\Models\AmcStatus;
use App\Models\AmcStatusAlloc;
use App\Models\Location;
use App\Models\School;
use App\Models\Status;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AmcStatusAllocController extends Controller
{
    use CsvImportTrait;

  
    public function index(Request $request)
{
    abort_if(Gate::denies('amc_status_alloc_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    if ($request->ajax()) {
        $query = AmcStatusAlloc::with(['asset', 'school', 'location', 'sublocation', 'status'])
            ->select(sprintf('%s.*', (new AmcStatusAlloc)->getTable()));

        $table = Datatables::of($query)
            ->addIndexColumn(); // ✅ Adds SL No column as DT_RowIndex

        $table->addColumn('placeholder', '&nbsp;');
        $table->addColumn('actions', '&nbsp;');

        $table->editColumn('actions', function ($row) {
            $viewGate      = 'amc_status_alloc_show';
            $editGate      = 'amc_status_alloc_edit';
            $deleteGate    = 'amc_status_alloc_delete';
            $crudRoutePart = 'amc-status-allocs';

            return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
        });

        $table->editColumn('asset', function ($row) {
            return $row->asset ? $row->asset->unique_id . ' - ' . $row->asset->asset_name : '-';
        });

        $table->editColumn('school_id', function ($row) {
            return $row->school_id ? $row->school_id : '-';
        });

        $table->editColumn('location_id', function ($row) {
            return $row->location_id ? $row->location_id: '-';
        });

        $table->editColumn('sub_location_id', function ($row) {
            return $row->sub_location_id ? $row->sub_location_id : '-';
        });

        $table->editColumn('product_status_id', function ($row) {
            return $row->product_status_id ? $row->product_status_id : '-';
        });

         $table->editColumn('amc_status_id', function ($row) {
            return $row->amc_status_id ? $row->amc_status_id : '-';
        });

        $table->editColumn('amc_date', function ($row) {
            return $row->amc_date ? \Carbon\Carbon::parse($row->amc_date)->format('Y-m-d') : '-';
        });

        $table->editColumn('amc_remarks', function ($row) {
            return $row->amc_remarks ?? '-';
        });

        $table->editColumn('amc_agent', function ($row) {
            return $row->amc_agent ?? '-';
        });

        $table->rawColumns(['actions', 'placeholder']);

        return $table->make(true);
    }

    return view('admin.amcStatusAllocs.index');
}

    


    public function create()
{
    abort_if(Gate::denies('amc_status_alloc_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $assets = Allocation::select('id', 'unique_id', 'asset_name')->get();

    return view('admin.amcStatusAllocs.create', compact('assets'));
}



public function store(Request $request)
{
   // dd($request->all());
    $data = $request->except(['amc_multi_gallery', 'video']);


    // Handle video file
    if ($request->hasFile('video')) {
        $data['video'] = $request->file('video')->store('uploads/videos', 'public');
    }

    $amcStatusAlloc = AmcStatusAlloc::create($data);

    // Handle multiple gallery images
    if ($request->hasFile('amc_multi_gallery')) {
        foreach ($request->file('amc_multi_gallery') as $image) {
            $imagePath = $image->store('uploads/products', 'public');
            AmcgalleryImage::create([
                'amcgallery_id' => $amcStatusAlloc->id,
                'image' => $imagePath,
            ]);
        }
    }

    return redirect()->route('admin.amc-status-allocs.index')
        ->with('success', 'AMC status saved successfully.');
}



    public function edit(AmcStatusAlloc $amcStatusAlloc)
{
    //dd($amcStatusAlloc);
    abort_if(Gate::denies('amc_status_alloc_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $assets = Allocation::select('id', 'unique_id', 'asset_name')->get();
    $schools = School::select('id', 'name')->get();
    $locations = Location::select('id', 'name')->get();
    $statuses = Status::select('id', 'name')->get();
     $amcstatuses = AmcStatus::select('id', 'name')->get();
    $galleryImages = $amcStatusAlloc->AmcImageGallery;

    return view('admin.amcStatusAllocs.edit', compact(
        'amcStatusAlloc', 'assets', 'schools', 'locations', 'statuses', 'galleryImages','amcstatuses'
    ));
}



    public function update(Request $request, AmcStatusAlloc $amcStatusAlloc)
{
    //dd($request->all());
    $data = $request->except(['amc_multi_gallery', 'video']);

    // Handle new video upload (optional replacement)
    if ($request->hasFile('video')) {
        $data['video'] = $request->file('video')->store('uploads/videos', 'public');
    }

    $amcStatusAlloc->update($data);

    // Handle new gallery images (append to existing)
    if ($request->hasFile('amc_multi_gallery')) {
        foreach ($request->file('amc_multi_gallery') as $image) {
            $imagePath = $image->store('uploads/products', 'public');
            AmcgalleryImage::create([
                'amcgallery_id' => $amcStatusAlloc->id,
                'image' => $imagePath,
            ]);
        }
    }

    return redirect()->route('admin.amc-status-allocs.index')
        ->with('success', 'AMC status updated successfully.');
}


  public function show(AmcStatusAlloc $amcStatusAlloc)
{
    abort_if(Gate::denies('amc_status_alloc_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $amcStatusAlloc->load(['asset', 'school', 'location', 'sublocation', 'status', 'AmcImageGallery','amcStatus']);
    $galleryImages = $amcStatusAlloc->AmcImageGallery;

    return view('admin.amcStatusAllocs.show', compact('amcStatusAlloc', 'galleryImages'));
}



    public function destroy(AmcStatusAlloc $amcStatusAlloc)
    {
        abort_if(Gate::denies('amc_status_alloc_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $amcStatusAlloc->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        $amcStatusAllocs = AmcStatusAlloc::find(request('ids'));

        foreach ($amcStatusAllocs as $amcStatusAlloc) {
            $amcStatusAlloc->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function getAssetDetails(Request $request)
{
    $allocation = Allocation::with([
        'school',
        'location',
        'sublocation',
        'status',
        'amcStatus'
    ])->find($request->asset_id);

    if (!$allocation) {
        return response()->json(['error' => 'Asset not found.'], 404);
    }

    return response()->json([
        'school_name'       => $allocation->school->name ?? '',
        'location_name'     => $allocation->location->name ?? '',
        'sub_location_name' => $allocation->sublocation->sub_location ?? '',
        'status_name'       => $allocation->status->name ?? '',
        'amc_status'       => $allocation->amcStatus->name ?? '',
        'amc_date'          => optional($allocation->created_at)->format('Y-m-d'),
    ]);
}


public function deleteGalleryImage($id)
{
    $image = AmcgalleryImage::find($id);

    if (!$image) {
        return response()->json([
            'status' => 'error',
            'message' => 'Image not found.'
        ], 404);
    }

    // Delete file from storage
    if (\Storage::disk('public')->exists($image->image)) {
        \Storage::disk('public')->delete($image->image);
    }

    // Delete DB record
    $image->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Image deleted successfully.'
    ]);
}




public function amsStatusDash(Request $request)
{
    // Get all AmcStatusAlloc asset_ids into a simple array for easy lookup
    $amcAllocatedAssetIds = AmcStatusAlloc::pluck('asset_id')->toArray();

    // Fetch filter values from request
    $locationId = $request->input('location_id');
    $sublocationId = $request->input('sublocation_id');

    // Query allocations with relationships
    $allocationsQuery = Allocation::with(['school', 'location', 'sublocation', 'status', 'custody', 'amcStatus']);

    if ($locationId) {
        $allocationsQuery->where('location_id', $locationId);
    }

    if ($sublocationId) {
        $allocationsQuery->where('sublocation_id', $sublocationId);
    }

    $allocations = $allocationsQuery->get();

    // Load all locations and sublocations for dropdowns
    $locations = Location::all();
    $sublocations = Location::all(); // If sublocation is also in same table

    return view('admin.amcStatusAllocs.dashboard', compact(
        'allocations',
        'amcAllocatedAssetIds',
        'locations',
        'sublocations',
        'locationId',
        'sublocationId'
    ));
}




}