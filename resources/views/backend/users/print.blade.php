<!DOCTYPE html>
<html>
<head>
    <title>Printable User List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
<div class="container mt-4">

    <div class="no-print mb-3 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Printable User List</h2>
        <button onclick="window.print()" class="btn btn-primary">Print</button>
    </div>

    {{-- Optional Filter Summary --}}
    @if (!empty($filters))
        <div class="mb-3">
            <strong>Filters:</strong>
            <ul class="mb-0">
                @foreach ($filters as $key => $value)
                    @if ($value)
                        <li><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif

    <table class="table table-bordered table-sm">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->roles->pluck('name')->first() ?? '-' }}</td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</body>
</html>
