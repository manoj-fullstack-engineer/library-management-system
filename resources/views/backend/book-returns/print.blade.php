<!DOCTYPE html>
<html>
<head>
    <title>Print - Book Returns</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Returned Book Report</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Library ID</th>
                <th>Student</th>
                <th>Book</th>
                <th>Returned</th>
                <th>Condition</th>
                <th>Fine (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($returns as $return)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $return->student_library_id }}</td>
                    <td>{{ $return->student->name ?? '-' }}</td>
                    <td>{{ $return->book->title ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($return->return_date)->format('d M Y') }}</td>
                    <td>{{ $return->condition_on_return }}</td>
                    <td>{{ number_format($return->fine_amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
