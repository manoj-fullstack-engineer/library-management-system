<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Categories Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 40px;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .meta {
            margin-bottom: 20px;
            font-size: 12px;
        }

        .meta strong {
            display: inline-block;
            width: 120px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #bbb;
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f4f4f4;
        }

        .status-active {
            color: green;
            font-weight: bold;
        }

        .status-inactive {
            color: red;
            font-weight: bold;
        }

        .footer {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }

        .signature-box {
            width: 200px;
            border-top: 1px solid #000;
            text-align: center;
            padding-top: 4px;
        }
    </style>
</head>
<body>
    <h2>📦 Inventory Categories Report</h2>

    {{-- Metadata --}}
    <div class="meta">
        <div><strong>Exported By:</strong> {{ auth()->user()->name ?? 'System' }}</div>
        <div><strong>Date:</strong> {{ now()->format('d M Y, h:i A') }}</div>
    </div>

    {{-- Table --}}
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $index => $cat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $cat->name }}</td>
                    <td>{{ $cat->description ?: '-' }}</td>
                    <td>
                        <span class="{{ $cat->status ? 'status-active' : 'status-inactive' }}">
                            {{ $cat->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $cat->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Footer --}}
    <div class="footer">
        <div></div>
        <div class="signature-box">Signature</div>
    </div>
</body>
</html>
