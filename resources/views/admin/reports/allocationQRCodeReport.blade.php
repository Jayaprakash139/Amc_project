@extends('layouts.admin')
@section('content')

  <style>
        .qr-canvas {
            display: none;
        }
    </style>

<div class="card">
    <div class="card-header">
        <div class="row">
            {{-- qr code pdf dowload button  --}}

            <div class="col-md-4 mt-4" style="font-size: 20px;">
                {{-- {{ trans('Filter and Check, Dowload Allocation QR Codes') }} {{ trans('Reports Here ') }}
                   <button id="downloadAllQRCodes" class="btn btn-success mb-3 mt-2">Download All QR Codes</button> --}}

<button id="downloadAllQRCodes" class="btn btn-success">Download All QR Codes as PDF</button>

<script>
    document.getElementById('downloadAllQRCodes').addEventListener('click', async function () {
    const button = this;
    button.textContent = "Downloading...";
    
    setTimeout(() => {
        button.textContent = "Download All QR Codes as PDF";
    }, 1000); // Revert text after 1 second

    // Your existing PDF generation and download logic here
});

</script>


<div id="qr-container">
    @foreach ($assets as $asset)
        <canvas class="qr-canvas" id="qrcode{{ $asset->id }}"></canvas>
      
    @endforeach
</div>
            </div>

            

            {{-- qr code pdf dowload button  --}}


    
            <form method="POST" action="{{ route('admin.allocationQRCode.filter') }}" class="col-md-8 row">
                @csrf
                <div class="col-md-3">
                    <label for="start_date">{{ trans('Start Date') }}</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date', old('start_date', '')) }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date">{{ trans('End Date') }}</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date', old('end_date', '')) }}">
                </div>
                <div class="col-md-3">
                    <label for="school">{{ trans('School') }}</label>
                    <select class="form-control select2 {{ $errors->has('school') ? 'is-invalid' : '' }}" name="school" id="school" required>
                        @foreach($schools as $id => $entry)
                            <option value="{{ $id }}" {{ request('school', old('school', '')) == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mt-4">
                    <label>&nbsp;</label>
                    <button class="btn btn-primary">{{ trans('Filter') }}</button>
                     <a href="{{ route('admin.reports.QRCodeAllocationReport') }}" class="btn btn-secondary">Reset</a>
                </div>


            </form>

             
        </div>
    </div>
 
    

    
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Allocation">
                <thead>
                    {{-- <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('SlNo') }}
                        </th>
                       
                        <th>
                            {{ trans('AMS U.Id') }}
                        </th>
                        <th>
                            {{ trans('Asset Code') }}
                        </th>
                        <th>
                            {{ trans('Asset Category') }}
                        </th>
                        <th>
                            {{ trans('Asset Name') }}
                        </th>
                        <th>
                            {{ trans('School Name') }}
                        </th>
                       
                        <th>
                            {{ trans('Location') }}
                        </th>
                        <th>
                            {{ trans('Value') }}
                        </th>
                        <th>
                            {{ trans('Status') }}
                        </th>
                        <th>
                            {{ trans('Custody') }}
                        </th>
                        <th>
                            {{ trans('Image') }}
                        </th>
                        <th>
                            {{ trans('QR Code') }}
                        </th>
                       
                    </tr> --}}
                </thead>
                <tbody>
                    <?php 
                    $count=0;
                    ?>
                    @foreach($assets as $key => $assetCategory)
                        {{--  <tr data-entry-id="{{ $assetCategory->id }}">
                            <td>
                               
                            </td>
                            <td>
                                {{ ++$count }}
                            </td>
                            <td>
                            
                                {{ $assetCategory->unique_id ?? '' }}
                            </td>
                            <td>
                            
                                {{ $assetCategory->asset_code ?? '' }}
                            </td>
                            <td>
                                {{ $assetCategory->aaset_category->category_name ?? '' }}
                            </td>
                            <td>
                                {{ $assetCategory->asset_name ?? '' }}
                                
                            </td>
                            <td>
                                {{ $assetCategory->school->name ?? '' }}
                            </td>
                            
                            <td>
                                {{ $assetCategory->sublocation->name ?? '' }}
                             
                            </td>
                            <td>
                                {{ $assetCategory->value ?? '' }}
                             
                            </td>
                            <td>
                                {{ $assetCategory->status->name ?? '' }}
                            </td>
                            <td>
                                {{ $assetCategory->custody->name ?? '' }}
                            </td>
                            <td><img src="{{ asset('storage/'.$assetCategory->image) }}" width="90px" height="70px" /></td>
   
                             {{-- QR Code 

                             <td style="text-align: center;">
                                    <!-- Add canvas with the correct ID -->
                                    <div style="border: 1px solid black;" class="p-2">
                                        <canvas class="qrcode-container" id="qrcode{{ $assetCategory->id }}"
                                            ></canvas>

                                        <br>
                                        <p style="font-size:12px; margin-bottom: 0px !important;">
                                            {{ $assetCategory->unique_id ?? '' }}</p>
                                        <p style="font-size:12px;margin-bottom: 1px !important;">
                                            {{ Str::limit($assetCategory->asset_name ?? '', 18, '') }}</p>

                                    </div>

                                    <a href="#" class="download-link" data-id="{{ $assetCategory->id }}">Download</a>
                                </td>
                      QR Code 


                        </tr>--}}
                    @endforeach
                </tbody>
            </table>


            <div id="qr-container">
    <!-- QR canvases will be generated here dynamically -->
</div>


        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent

<script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>

<script>



       document.addEventListener("DOMContentLoaded", function() {
    @foreach ($assets as $assetCategory)
        (function() {
            const assetId = '{{ $assetCategory->id }}';
            const uniqueId = '{{ $assetCategory->unique_id ?? '' }}';
            const assetName = '{{ Str::limit($assetCategory->asset_name ?? '', 18, '') }}';
            const fullName = '{{ $assetCategory->asset_name ?? '' }}';
            const assetCode = '{{ $assetCategory->asset_code ?? '' }}';
            const schoolName = '{{ $assetCategory->school->name ?? '' }}';
            const locationName = '{{ $assetCategory->location->name ?? '' }}';
             const sublocationName = '{{ $assetCategory->sublocation->sub_location ?? '' }}';
          
            const statusName = '{{ $assetCategory->status->name ?? '' }}';
            const custodyName = '{{ $assetCategory->custody->name ?? '' }}';

            const amcstatus = '{{ $assetCategory->amcStatus->name ?? '' }}';
            const amcdate = '{{ $assetCategory->amcStatus->created_at ?? '' }}';

            // Full QR data
            const qrCodeData =
                `AMS UID: ${uniqueId}, Assets: ${fullName}, Asset Code: ${assetCode}, School: ${schoolName}, location: ${locationName},Sub location: ${sublocationName}, Product Status: ${statusName}, Custody: ${custodyName},AMC Status: ${amcstatus}, AMC Date: ${amcdate}`;

            // Generate QR code using QRious
            new QRious({
                element: document.getElementById('qrcode' + assetId),
                value: qrCodeData,
                size: 260,
                level: 'H',
                backgroundAlpha: 0 // Transparent background
            });

            // Download logic
            const downloadBtn = document.querySelector(".download-link[data-id='" + assetId + "']");
            if (downloadBtn) {
                downloadBtn.addEventListener("click", function(e) {
                    e.preventDefault();

                    const qrCanvas = document.getElementById('qrcode' + assetId);
                    const qrDataUrl = qrCanvas.toDataURL();

                    const qrImg = new Image();
                    

                   
qrImg.onload = function() {
    const scaleFactor = 4; // High-res scaling factor
    const qrSize = 63; // QR Code size (original dimensions)
    const padding = 5;
    const borderRadius = 12;
    const labelWidth = 170;
    const labelHeight = 70;

    // Create high-resolution canvas
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    // Set high-res dimensions (scaled for better clarity)
    canvas.width = labelWidth * scaleFactor;
    canvas.height = labelHeight * scaleFactor;
    ctx.scale(scaleFactor, scaleFactor); // Apply scaling for crisp rendering

    // Draw rounded border
    ctx.fillStyle = "#fff";
    ctx.strokeStyle = "#b4b4b4";
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.roundRect(0, 0, labelWidth, labelHeight, borderRadius);
    ctx.fill();
    ctx.stroke();

    // Draw QR code in correct position
    const qrX = padding;
    const qrY = padding;
    ctx.drawImage(qrImg, qrX, qrY, qrSize, qrSize);

    // **Text Formatting Fixes**
    ctx.fillStyle = "#000";
    ctx.textAlign = "left";

    // Define font sizes separately (fixed size instead of scaled)
    ctx.font = "bold 7px Arial";

    // **School Name Fix**
    const maxSchoolChars = 30; // Allow more characters for better readability
    const schoolText = schoolName.length > maxSchoolChars ? schoolName.substring(0, maxSchoolChars) + '...' : schoolName;
    ctx.fillText(schoolText, qrX + qrSize + 15, qrY + 12);

    // **UID Fix**
    ctx.font = "bold 7px Arial"; // Keep UID slightly smaller but clear
    ctx.fillText(uniqueId, qrX + qrSize + 15, qrY + 28);

    // **Asset Name Fix**
    ctx.font = "normal 6px Arial"; // Ensure readable font weight
    ctx.fillText(assetName, qrX + qrSize + 15, qrY + 45);

    // **Download in HD Quality**
    const finalImage = canvas.toDataURL("image/png", 1.0); // Ensure max quality PNG
    const link = document.createElement("a");
    link.href = finalImage;
    link.download = "qr_" + uniqueId + ".png";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};



                     

                    qrImg.src = qrDataUrl;
                });
            }
        })();
    @endforeach
});


</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

{{-- qr code pdf dowload button  --}}
{{-- 
<script>
document.getElementById('downloadAllQRCodes').addEventListener('click', async function () {
    const data = [];

    @foreach ($assets as $asset)
        data.push({
            id: '{{ $asset->id }}',
            uniqueId: '{{ $asset->unique_id ?? '' }}',
            assetName: '{{ Str::limit($asset->asset_name ?? '', 25, '') }}'
        });
    @endforeach

    const A4_WIDTH = 794;
    const A4_HEIGHT = 1123;
    const qrSize = 120;
    const padding = 1;
    const textHeight = 50;
    const borderWidth = 4;
    const canvasPerRow = 3;

    const blockWidth = qrSize + padding * 2;
    const blockHeight = qrSize + textHeight + padding * 2;
    const blockWithBorder = blockHeight + borderWidth * 2;

    const rowsPerPage = Math.floor((A4_HEIGHT - 20) / blockWithBorder);
    const itemsPerPage = canvasPerRow * rowsPerPage;

    const pages = Math.ceil(data.length / itemsPerPage);

    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({ orientation: "portrait", unit: "px", format: [A4_WIDTH, A4_HEIGHT] });

    const scale = 3;
    const scaledWidth = A4_WIDTH * scale;
    const scaledHeight = A4_HEIGHT * scale;

    for (let page = 0; page < pages; page++) {
        const fullCanvas = document.createElement('canvas');
        fullCanvas.width = scaledWidth;
        fullCanvas.height = scaledHeight;
        const ctx = fullCanvas.getContext('2d');

        ctx.scale(scale, scale);
        ctx.fillStyle = "#fff";
        ctx.fillRect(0, 0, A4_WIDTH, A4_HEIGHT);

        const start = page * itemsPerPage;
        const end = Math.min(start + itemsPerPage, data.length);
        const images = [];

        for (let i = start; i < end; i++) {
            const item = data[i];
            const qrCanvas = document.getElementById('qrcode' + item.id);
            const img = new Image(qrSize, qrSize);
            img.src = qrCanvas.toDataURL("image/png");

            await new Promise(resolve => {
                img.onload = function () {
                    images.push({ img, item });
                    resolve();
                };
            });
        }

        images.forEach((block, idx) => {
            const row = Math.floor(idx / canvasPerRow);
            const col = idx % canvasPerRow;

            // Centering logic
            const totalRowWidth = canvasPerRow * (blockWidth + borderWidth * 2);
            const startX = (A4_WIDTH - totalRowWidth) / 2;

            const x = startX + col * (blockWidth + borderWidth * 2);
            const y = row * (blockHeight + borderWidth * 2) + 10;

            const { img, item } = block;

            ctx.strokeStyle = "yellow";
            ctx.lineWidth = borderWidth;
            ctx.strokeRect(x, y, blockWidth + borderWidth * 2, blockHeight + borderWidth * 2);

            ctx.fillStyle = "#fff";
            ctx.fillRect(x + borderWidth, y + borderWidth, blockWidth, blockHeight);

            ctx.drawImage(
                img,
                x + borderWidth + padding,
                y + borderWidth + padding,
                qrSize,
                qrSize
            );

            ctx.fillStyle = "#000";
            ctx.font = "7px Arial"; // Reduced font size
            ctx.textAlign = "center";
            const centerX = x + borderWidth + blockWidth / 2;
            ctx.fillText(item.uniqueId, centerX, y + borderWidth + padding + qrSize + 18);
            ctx.fillText(item.assetName, centerX, y + borderWidth + padding + qrSize + 35);
        });

        const imgData = fullCanvas.toDataURL("image/png", 1.0);
        if (page > 0) pdf.addPage();
        pdf.addImage(imgData, "PNG", 0, 0, A4_WIDTH, A4_HEIGHT);
    }

    pdf.save("Filtered_QRCodes_A4_HighQuality.pdf");
});
</script>



<script>
document.getElementById('downloadAllQRCodes').addEventListener('click', async function () {
    const button = this;
    const originalText = button.innerHTML;

    // Show loading message
    button.innerHTML = 'Downloading QR Code Reports...';
    button.disabled = true;

    // Wait 2 seconds
    await new Promise(resolve => setTimeout(resolve, 2000));

    // Restore original button text and re-enable
    button.innerHTML = originalText;
    button.disabled = false;

    // Exit function here to stop further execution
    return;

    // The code below won't execute because of the return above
    const data = [];

    @foreach ($assets as $asset)
        data.push({
            id: '{{ $asset->id }}',
            uniqueId: '{{ $asset->unique_id ?? '' }}',
            assetName: '{{ Str::limit($asset->asset_name ?? '', 18, '') }}'
        });
    @endforeach

    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({ orientation: "portrait", unit: "px", format: [794, 1123] });

    // Your QR generation logic here...

    pdf.save("Filtered_QRCodes_A4_HighQuality.pdf");
});
</script> --}}

{{-- qr code pdf dowload button  --}}


{{-- 
<script>
    document.addEventListener("DOMContentLoaded", function () {
        @foreach ($assets as $asset)
            (function () {
                const assetId = '{{ $asset->id }}';
                const qrCodeData = `AMS UID: {{ $asset->unique_id ?? '' }}, Assets: {{ $asset->asset_name ?? '' }}, Asset Code: {{ $asset->asset_code ?? '' }}, School: {{ Str::limit($asset->school->name ?? '', 40, '') }}`;

                new QRious({
                    element: document.getElementById('qrcode' + assetId),
                    value: qrCodeData,
                    size: 260,
                    level: 'H',
                    backgroundAlpha: 0
                });
            })();
        @endforeach
    });
</script> --}}

{{-- 

<script>
    document.getElementById('downloadAllQRCodes').addEventListener('click', async function () {
        const data = [
            @foreach ($assets as $asset)
                {
                    id: '{{ $asset->id }}',
                    uniqueId: '{{ $asset->unique_id ?? '' }}',
                    assetName: '{{ Str::limit($asset->asset_name ?? '', 15, '') }}',
                    schoolName: '{{ Str::limit($asset->school->name ?? '', 40, '') }}'
                },
            @endforeach
        ];

        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF({ orientation: "portrait", unit: "pt", format: "a4" });

        const labelWidth = 180;
        const labelHeight = 108;
        const qrSize = 70;
        const padding = 10;
        const labelsPerRow = 3;
        const labelsPerColumn = 7;
        const labelsPerPage = labelsPerRow * labelsPerColumn;

        const totalPages = Math.ceil(data.length / labelsPerPage);

        for (let page = 0; page < totalPages; page++) {
            if (page > 0) pdf.addPage();

            const start = page * labelsPerPage;
            const end = Math.min(start + labelsPerPage, data.length);

            for (let i = start; i < end; i++) {
                const indexOnPage = i - start;
                const row = Math.floor(indexOnPage / labelsPerRow);
                const col = indexOnPage % labelsPerRow;

                const x = col * labelWidth;
                const y = row * labelHeight;

                const item = data[i];
                const canvas = document.getElementById('qrcode' + item.id);
                if (!canvas) continue;

                const qrImage = canvas.toDataURL("image/png");

                // Draw border
                pdf.setDrawColor(180);
                pdf.rect(x, y, labelWidth, labelHeight);

                // Draw QR code
                const qrX = x + padding;
                const qrY = y + padding;
                pdf.addImage(qrImage, 'PNG', qrX, qrY, qrSize, qrSize);

                const textX = qrX + qrSize + 10;
                const lineHeight = 10;

                // === Text Formatting ===

                // Manual 2-line break for school name (max 36 chars)
                const schoolText = item.schoolName.length > 36
                    ? item.schoolName.substring(0, 36) + '...'
                    : item.schoolName;

                const schoolLines = [
                    schoolText.slice(0, 18).trim(),
                    schoolText.slice(18).trim()
                ];

                const uidLine = item.uniqueId;
                const assetLine = item.assetName;

                // Total text height: 2 (school lines) + 2 (UID + Asset)
                const totalTextHeight = 4 * lineHeight;

                // Vertically center all text block with respect to QR code
                const qrCenterY = qrY + qrSize / 2;
                const textStartY = qrCenterY - totalTextHeight / 2 + lineHeight;

                // === Drawing Text ===

                pdf.setFontSize(8);
                pdf.setFont("helvetica", "normal");

                schoolLines.forEach((line, idx) => {
                    pdf.text(line, textX, textStartY + idx * lineHeight);
                });

                const offset = schoolLines.length * lineHeight;

                pdf.setFont("helvetica", "bold");
                pdf.text(uidLine, textX, textStartY + offset);

                pdf.setFont("helvetica", "normal");
                pdf.text(assetLine, textX, textStartY + offset + lineHeight);
            }
        }

        pdf.save("Filtered_QRCodes_A4_Final.pdf");
    });
</script> --}}


<script>
 
document.getElementById('downloadAllQRCodes').addEventListener('click', async function () {
    const data = [
        @foreach ($assets as $asset)
            {
                id: '{{ $asset->id }}',
                uniqueId: '{{ $asset->unique_id ?? '' }}',
                assetName: '{{ Str::limit($asset->asset_name ?? '', 15, '') }}',
                schoolName: '{{ Str::limit($asset->school->name ?? '', 30, '') }}' // Further reduced length
            },
        @endforeach
    ];

    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({ orientation: "portrait", unit: "pt", format: "a4" });

    const labelWidth = 180;
    const labelHeight = 90;
    const qrSize = 80;
    const padding = 7;
    const labelsPerRow = 3;
    const labelsPerColumn = 8;
    const labelsPerPage = labelsPerRow * labelsPerColumn;

    const marginX = 20;
    const marginY = 30;
    const gapBetweenCards = 7;
    const borderRadius = 10;

    const schoolNameMargin = 20;  // Adjusted margin for single-line school name
    const uIdGap = 7;            // Reduced gap below unique ID
    const assetGap = 3;          // Minimal space below asset name

    const totalPages = Math.ceil(data.length / labelsPerPage);

    for (let page = 0; page < totalPages; page++) {
        if (page > 0) pdf.addPage();

        const start = page * labelsPerPage;
        const end = Math.min(start + labelsPerPage, data.length);

        for (let i = start; i < end; i++) {
            const indexOnPage = i - start;
            const row = Math.floor(indexOnPage / labelsPerRow);
            const col = indexOnPage % labelsPerRow;

            const x = marginX + col * (labelWidth + gapBetweenCards);
            const y = marginY + row * (labelHeight + gapBetweenCards);

            const item = data[i];
            const canvas = document.getElementById('qrcode' + item.id);
            if (!canvas) continue;

            const qrImage = canvas.toDataURL("image/png");

            // Draw rounded border
            pdf.setDrawColor(180);
            pdf.roundedRect(x, y, labelWidth, labelHeight, borderRadius, borderRadius);

            // Draw QR code
            const qrX = x + padding;
            const qrY = y + padding;
            pdf.addImage(qrImage, 'PNG', qrX, qrY, qrSize, qrSize);

            const textX = qrX + qrSize + 15;

            // === Reduced School Name Formatting ===
            const schoolText = item.schoolName.length > 30 ? item.schoolName.substring(0, 23) + '...' : item.schoolName;

            const uidLine = item.uniqueId;
            const assetLine = item.assetName;

            // Text positioning with adjusted gaps
            const textStartY = y + schoolNameMargin;

            pdf.setFontSize(4); // **Further reduced font size** for school name
            pdf.setFont("helvetica", "bold");
            pdf.text(schoolText, textX, textStartY); // Single-line school name

            const offset = 10 + uIdGap;

            pdf.setFontSize(8); // Font size for unique ID
            pdf.setFont("helvetica", "bold");
            pdf.text(uidLine, textX, textStartY + offset);

            const assetOffset = offset + 10 + assetGap;

            pdf.setFontSize(8); // Font size for asset name
            pdf.setFont("helvetica", "normal");
            pdf.text(assetLine, textX, textStartY + assetOffset);
        }
    }

    pdf.save("Final_Aligned_QRCodes.pdf");
});


</script>



@endsection