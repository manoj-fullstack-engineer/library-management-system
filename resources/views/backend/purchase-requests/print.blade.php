<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Requests - Print View</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
            margin: 0;
        }
        .filters {
            margin-top: 15px;
            font-size: 12px;
        }
        .footer, .summary {
            margin-top: 30px;
            font-size: 12px;
            display: flex;
            justify-content: space-between;
        }
        .signature {
            margin-top: 60px;
            text-align: right;
        }
        .buttons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .buttons button {
            padding: 8px 16px;
            font-size: 13px;
            cursor: pointer;
        }

        @media print {
            .buttons {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h2>📝 Purchase Requests Report</h2>

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
            @php
                $totalQuantity = 0;
            @endphp
            @foreach($purchaseRequests as $index => $request)
                @php
                    $totalQuantity += $request->quantity;
                @endphp
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

    <div class="summary">
        <div>
            <strong>Total Items:</strong> {{ $purchaseRequests->count() }}<br>
            <strong>Total Quantity:</strong> {{ $totalQuantity }}
        </div>
    </div>

    <div class="footer">
        <div>
            <strong>Printed on:</strong> {{ now()->format('d M Y, h:i A') }}<br>
            <strong>Printed by:</strong> {{ auth()->user()->name ?? 'System' }}
        </div>
        <div class="signature">
            ___________________________<br>
            <strong>Librarian Signature</strong>
        </div>
    </div>

    <div class="buttons">
        <button onclick="window.print()">🖨️ Print</button>
        <button onclick="window.close()">❌ Exit</button>
    </div>
</body>
</html>
