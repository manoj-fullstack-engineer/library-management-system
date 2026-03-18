<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Book Return Logs - PDF</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px 8px;
        }
        th {
            background: #f0f0f0;
        }
        tfoot td {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
        }
        .signature {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }
        .signature div {
            width: 30%;
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    <h2>📘 Book Return Logs</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Student ID</th>
                <th>Book ID</th>
                <th>Return Date</th>
                <th>Condition</th>
                <th>Fine (₹)</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            @php $totalFine = 0; @endphp
            @forelse($returns as $index => $log)
                @php $totalFine += $log->fine_amount; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $log->student_library_id }}</td>
                    <td>{{ $log->book_id }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->return_date)->format('d M Y, h:i A') }}</td>
                    <td>{{ $log->book_condition }}</td>
                    <td>{{ number_format($log->fine_amount, 2) }}</td>
                    <td>{{ $log->return_remark }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">No return logs found.</td>
                </tr>
            @endforelse
        </tbody>
        @if($returns->count())
        <tfoot>
            <tr>
                <td colspan="5" style="text-align:right;">Total Fine:</td>
                <td colspan="2">₹ {{ number_format($totalFine, 2) }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="signature">
        <div>Checked By</div>
        <div>Verified By</div>
        <div>Authorized Signature</div>
    </div>

    <div class="footer">
        Generated on: {{ now()->format('d M Y, h:i A') }}
    </div>

</body>
</html>
