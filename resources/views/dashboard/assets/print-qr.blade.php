<!DOCTYPE html>
<html>

<head>
    <title>QR Code - {{ $asset->name }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            font-family: Arial, sans-serif;
        }

        .asset-info {
            text-align: center;
            margin-bottom: 10px;
        }

        .qr-container {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }

        .btn {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 20px 2px;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    {{-- <div class="asset-info">
        <h2>{{ $asset->name }}</h2>
    </div> --}}

    <div class="qr-container">
        {!! $qrCode !!}
    </div>

    <script>
        // Auto-print when the page loads
        window.onload = function() {
            // Short delay to ensure the QR renders properly
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>

</html>
