<!DOCTYPE html>
<html>
<head>
    <title>Permissions PDF</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f5f5f5; text-align: left; }
    </style>
</head>
<body>
    <h2>Permission Report</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Guard</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $index => $permission)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->guard_name }}</td>
                    <td>{{ $permission->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
