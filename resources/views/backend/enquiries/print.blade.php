<!DOCTYPE html>
<html>
<head>
    <title>Print Enquiries</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f4f4f4; }

        /* Hide buttons when printing */
        @media print {
            .no-print {
                display: none !important;
            }
        }

        .button-bar {
            text-align: center;
            margin-top: 30px;
        }

        .button-bar button {
            padding: 10px 20px;
            margin: 0 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <h2>Enquiry List</h2>

    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Date</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Subject</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($enquiries as $index => $enquiry)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $enquiry->created_at->format('Y-m-d') }}</td>
                    <td>{{ $enquiry->name }}</td>
                    <td>{{ $enquiry->email }}</td>
                    <td>{{ $enquiry->phone }}</td>
                    <td>{{ $enquiry->subject }}</td>
                    <td>{{ $enquiry->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No data found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="button-bar no-print">
        <button onclick="window.print()" class="btn btn-primary">Print</button>
        <button onclick="window.close()" class="btn btn-danger">Exit</button>
    </div>

</body>
</html>
