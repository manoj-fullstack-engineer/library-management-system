<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Roles List PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px;
            font-size: 12px;
        }
        th {
            background-color: #e9ecef;
            text-align: left;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
    <h2>Roles & Permissions Report</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Role Name</th>
                <th>Permissions</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $index => $role)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        @if($role->permissions->isNotEmpty())
                            @foreach($role->permissions as $permission)
                                <span>{{ $permission->name }}{{ !$loop->last ? ',' : '' }}</span>
                            @endforeach
                        @else
                            <span>N/A</span>
                        @endif
                    </td>
                    <td>{{ $role->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
