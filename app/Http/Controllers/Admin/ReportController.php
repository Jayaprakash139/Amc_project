<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Allocation;
use App\Models\School;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
class ReportController extends Controller
{
    public function assetAllotReport(){
        $schools = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $assets = Allocation::with(['school', 'aaset_category','status','custody','sublocation'])->get();

        return view('admin.reports.allocationReport', compact('assets','schools'));
    }

    public function filter(Request $request)
{
    $schools = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

    // Retrieve filter criteria from the request
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $selectedSchool = $request->input('school');

    // Apply filters to fetch the data from the database
    $filteredAssets = Allocation::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
        ->when($selectedSchool, function ($query) use ($selectedSchool) {
            return $query->where('school_id', $selectedSchool);
        })
        ->get();

    // Pass the filtered data to the view
    return view('admin.reports.allocationReport', ['assets' => $filteredAssets, 'schools' => $schools]);
}


 public function assetAllotQRCodeReport(){
        $schools = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $assets = Allocation::with(['school', 'aaset_category','status','custody','location','sublocation','amcStatus'])->get();

        return view('admin.reports.allocationQRCodeReport', compact('assets','schools'));
    }



    
public function downloadQRCodePdf(Request $request)
{
    $request->validate([
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date',
        'school' => 'required|integer',
    ]);

    $query = Allocation::with(['school', 'aaset_category', 'status', 'custody', 'sublocation'])
        ->where('school_id', $request->school);

    if ($request->start_date) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->end_date) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    $assets = $query->get();

    // 🧠 Call the QR generator before generating the PDF
    $this->generateQrCodesForAssets($assets);

    $pdf = PDF::loadView('admin.reports.qr_code_pdf', compact('assets'))->setPaper('a4', 'portrait');
    return $pdf->download('qr_code_report.pdf');
}


 private function generateQrCodesForAssets($assets)
    {
        foreach ($assets as $asset) {
            if (!$asset->qr_base64) {
                $qrData = 'AMS UID: ' . $asset->unique_id . ', Assets: ' . \Illuminate\Support\Str::limit($asset->asset_name ?? '', 22, '');
                $png = QrCode::format('png')->size(200)->generate($qrData);
                $base64 = 'data:image/png;base64,' . base64_encode($png);

                $asset->qr_base64 = $base64;
                $asset->save();
            }
        }
    }


    
    public function filterQRcodes(Request $request)
{
    $schools = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

    // Retrieve filter criteria from the request
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $selectedSchool = $request->input('school');

    // Apply filters to fetch the data from the database
    $filteredAssets = Allocation::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
        ->when($selectedSchool, function ($query) use ($selectedSchool) {
            return $query->where('school_id', $selectedSchool);
        })
        ->get();

    // Pass the filtered data to the view
    return view('admin.reports.allocationQRCodeReport', ['assets' => $filteredAssets, 'schools' => $schools]);
}






}
