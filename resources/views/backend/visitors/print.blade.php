<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Visitor Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-size: 14px; }
        .table th, .table td { padding: 6px 10px; }
        .table-bordered { border: 1px solid #dee2e6; }
        .table thead th { background-color: #f8f9fa; }
        .title { text-align: center; margin: 20px 0; font-size: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Visitor Report</div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>IP Address</th>
                    <th>Visited At</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($visitors as $key => $visitor)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $visitor->name }}</td>
                        <td>{{ $visitor->email ?? '—' }}</td>
                        <td>{{ $visitor->phone ?? '—' }}</td>
                        <td>{{ $visitor->ip_address ?? '—' }}</td>
                        <td>{{ optional($visitor->visited_at)->format('d/m/Y') }}</td>
                        <td>{{ $visitor->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No records found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
