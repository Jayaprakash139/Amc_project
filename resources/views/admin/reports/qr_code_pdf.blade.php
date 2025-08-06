<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>QR Code Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .qr-row { display: flex; flex-wrap: wrap; margin-bottom: 20px; }
        .qr-item { width: 20%; text-align: center; margin-bottom: 20px; }
        .qr-item img { width: 120px; height: 120px; }
    </style>
</head>
<body>
    <h3>QR Code Report</h3>
    <div class="qr-container">
        @foreach ($assets->chunk(5) as $chunk)
            <div class="qr-row">
                @foreach ($chunk as $asset)
                    <div class="qr-item">
                        {{-- Use pre-generated Base64 QR image --}}
                        @if($asset->qr_base64)
                            <img src="{{ $asset->qr_base64 }}" alt="QR Code">
                        @else
                            <p>No QR Image</p>
                        @endif
                        <p>{{ $asset->unique_id }}</p>
                        <p>{{ \Illuminate\Support\Str::limit($asset->asset_name, 22) }}</p>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</body>
</html>
