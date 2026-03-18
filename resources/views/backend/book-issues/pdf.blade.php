<!DOCTYPE html>
<html>
<head>
    <title>Issued Books Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h3>Issued Books Report</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Book</th>
                <th>Student</th>
                <th>Issued On</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($issues as $issue)
                <tr>
                    <td>{{ $issue->id }}</td>
                    <td>{{ $issue->book_title }}</td>
                    <td>{{ $issue->student->first_name ?? '-' }}</td>
                    <td>{{ $issue->issued_at }}</td>
                    <td>{{ $issue->due_date }}</td>
                    <td>{{ $issue->status }}</td>
                    <td>{{ $issue->remark }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
