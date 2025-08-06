<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Allocation;
use App\Models\School;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function assetAllotReport(){
        $schools = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $assets = Allocation::with(['school', 'aaset_category','status','custody','sublocation'])->get();

        return view('frontend.reports.allocationReport', compact('assets','schools'));
    }

    public function filtered(Request $request)
{
    $schools = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $selectedSchool = $request->input('school');
//dd($startDate, $endDate, $selectedSchool);
    
    $filteredAssets = Allocation::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
        ->when($selectedSchool, function ($query) use ($selectedSchool) {
            return $query->where('school_id', $selectedSchool);
        })
        ->get();

   
    return view('frontend.reports.allocationReport', ['assets' => $filteredAssets, 'schools' => $schools]);
}


}
