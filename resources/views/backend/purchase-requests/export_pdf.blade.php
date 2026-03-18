<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Requests - PDF Export</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #444;
            padding: 5px;
            text-align: left;
        }
        table th {
            background-color: #f0f0f0;
        }
        h2 {
            text-align: center;
            margin: 0;
        }
        .filters {
            margin-top: 10px;
            font-size: 11px;
        }
        .footer {
            margin-top: 40px;
            font-size: 11px;
            display: flex;
            justify-content: space-between;
        }
        .signature {
            margin-top: 60px;
            text-align: right;
        }
    </style>
</head>
<body>
    <h2>📝 Purchase Requests Export</h2>

    @if(!empty($filters))
        <div class="filters">
            <strong>Filters:</strong><br>
            @foreach($filters as $key => $value)
                @if($value)
                    {{ ucwords(str_replace('_', ' ', $key)) }}: {{ $value }}<br>
                @endif
            @endforeach
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Request No.</th>
                <th>Item Name</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>ISBN</th>
                <th>Quantity</th>
                <th>Cost</th>
                <th>Category</th>
                <th>Requested By</th>
                <th>Status</th>
                <th>Remark</th>
                <th>Requested At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseRequests as $index => $request)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $request->request_number }}</td>
                    <td>{{ $request->item_name }}</td>
                    <td>{{ $request->author ?? '-' }}</td>
                    <td>{{ $request->publisher ?? '-' }}</td>
                    <td>{{ $request->isbn ?? '-' }}</td>
                    <td>{{ $request->quantity }}</td>
                    <td>₹{{ number_format($request->estimated_cost, 2) }}</td>
                    <td>{{ $request->category->name ?? '-' }}</td>
                    <td>{{ $request->creator->name ?? '-' }}</td>
                    <td>{{ ucfirst($request->status) }}</td>
                    <td>{{ $request->remark ?? '-' }}</td>
                    <td>{{ $request->created_at->format('d-M-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div>
            <strong>Created on:</strong> {{ now()->format('d M Y, h:i A') }}<br>
            <strong>Created by:</strong> {{ auth()->user()->name ?? 'System' }}
        </div>
        <div class="signature">
            ___________________________<br>
            <strong>Librarian Signature</strong>
        </div>
    </div>
</body>
</html>
