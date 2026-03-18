<!DOCTYPE html>
<html>
<head>
    <title>Enquiry PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background: #f4f4f4; }
    </style>
</head>
<body>
    <h3>Enquiry Report</h3>
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
            @foreach($enquiries as $index => $enquiry)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $enquiry->created_at->format('Y-m-d') }}</td>
                    <td>{{ $enquiry->name }}</td>
                    <td>{{ $enquiry->email }}</td>
                    <td>{{ $enquiry->phone }}</td>
                    <td>{{ $enquiry->subject }}</td>
                    <td>{{ ucfirst($enquiry->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
