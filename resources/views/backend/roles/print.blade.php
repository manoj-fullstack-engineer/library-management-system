<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Roles Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-size: 14px;
            padding: 20px;
        }
        .table {
            width: 100%;
            table-layout: fixed;
            word-wrap: break-word;
        }
        .table th, .table td {
            vertical-align: middle;
            page-break-inside: avoid;
        }
        .print-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .print-header img {
            max-height: 60px;
            margin-bottom: 10px;
        }
        .print-header h2 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .print-header small {
            color: #6c757d;
        }
        .btn-print {
            display: block;
            margin: 20px auto;
        }
        @media print {
            .btn-print, .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<div class="print-header">
    {{-- Optional Logo --}}
    <img src="{{ asset('images/company-logo.png') }}" alt="Company Logo">

    <h2>Roles Report</h2>
    <small>Generated on {{ now()->format('d M Y, h:i A') }}</small><br>
    <small>Printed by: {{ auth()->user()->name ?? 'System' }}</small>
</div>

{{-- Filters Summary --}}
@if(request()->query())
    <div class="mb-3">
        <strong>Applied Filters:</strong>
        <ul class="mb-0">
            @foreach(request()->query() as $key => $value)
                @if(!empty($value))
                    <li>{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</li>
                @endif
            @endforeach
        </ul>
    </div>
@endif

{{-- Roles Table --}}
<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>Sr No</th>
            <th>Role Name</th>
            <th>Guard</th>
            <th>Permissions</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($roles as $index => $role)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->guard_name }}</td>
                <td>
                    @if ($role->permissions->count())
                        {{ $role->permissions->pluck('name')->join(', ') }}
                    @else
                        <span class="text-muted">No permissions</span>
                    @endif
                </td>
                <td>{{ $role->created_at->format('d/m/Y h:i A') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-muted">No roles found</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- Summary --}}
<div class="mt-3">
    <strong>Total Roles:</strong> {{ $roles->count() }}
</div>

{{-- Manual Print Button --}}
<button onclick="window.print()" class="btn btn-primary btn-print">
    <i class="fas fa-print me-2"></i>Print Report
</button>

{{-- Auto-print on load --}}
<script>
    window.addEventListener('load', function () {
        window.print();
    });
</script>

</body>
</html>
