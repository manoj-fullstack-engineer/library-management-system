@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    {{-- Success Notification --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h1 class="h2 mb-3 mb-md-0">Roles Management</h1>
        <div class="btn-group flex-wrap gap-2">
            <a href="{{ route('backend.roles.export.pdf', request()->query()) }}" class="btn btn-outline-danger">
                <i class="fas fa-file-pdf me-2"></i> Export PDF
            </a>
            <a href="{{ route('backend.roles.export.excel', request()->query()) }}" class="btn btn-outline-success">
                <i class="fas fa-file-excel me-2"></i> Export Excel
            </a>
            <a href="{{ route('backend.roles.print', request()->query()) }}" class="btn btn-secondary" target="_blank">
                <i class="fas fa-print me-2"></i> Print
            </a>
            <a href="{{ route('backend.roles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Add New
            </a>
        </div>
    </div>

    {{-- Filter Form --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
            <form method="GET" action="{{ route('backend.roles.index') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Role name...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">From</label>
                    <input type="text" name="start_date" value="{{ request('start_date') }}" class="form-control datepicker" placeholder="Start date">
                </div>
                <div class="col-md-2">
                    <label class="form-label">To</label>
                    <input type="text" name="end_date" value="{{ request('end_date') }}" class="form-control datepicker" placeholder="End date">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-filter me-2"></i> Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('backend.roles.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-sync-alt me-2"></i> Show All
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Roles Table --}}
    <div class="card shadow-sm border-0">
        <form method="POST" action="{{ route('backend.roles.bulk-delete') }}" id="bulkDeleteForm">
            @csrf
            @method('DELETE')

            <div class="d-flex justify-content-between align-items-center px-3 py-2 bg-light border-bottom">
                <button type="button" class="btn btn-danger" onclick="confirmBulkDelete(event)">
                    <i class="fas fa-trash-alt me-2"></i> Delete Selected
                </button>
                <div class="text-muted small">
                    Showing {{ $roles->firstItem() }} to {{ $roles->lastItem() }} of {{ $roles->total() }} entries
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="selectAll" class="form-check-input" style="transform: scale(1.2);">
                            </th>
                            <th width="60">#</th>
                            <th>Role Name</th>
                            <th>Guard</th>
                            <th>Created At</th>
                            <th width="280" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $index => $role)
                            <tr>
                                <td class="ps-3">
                                    <input type="checkbox" name="selected_roles[]" value="{{ $role->id }}" class="form-check-input select-item" style="transform: scale(1.2);">
                                </td>
                                <td>{{ $roles->firstItem() + $index }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->guard_name }}</td>
                                <td>{{ $role->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('backend.roles.show', $role->id) }}" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-eye me-1"></i> View
                                        </a>
                                        <a href="{{ route('backend.roles.edit', $role->id) }}" class="btn btn-outline-warning btn-sm">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('backend.roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirmDelete(event)">
                                                <i class="fas fa-trash-alt me-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fas fa-info-circle me-2"></i> No roles found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    {{-- Pagination & Per Page --}}
    <div class="d-flex justify-content-between align-items-center mt-3">
        <form method="GET" class="d-flex align-items-center gap-2">
            <label for="per_page" class="mb-0">Show:</label>
            <select name="per_page" id="per_page" class="form-select w-auto" onchange="this.form.submit()">
                @foreach ([10, 20, 50, 100] as $option)
                    <option value="{{ $option }}" {{ request('per_page', 10) == $option ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
                <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>All</option>
            </select>
            <span class="mb-0">entries</span>

            {{-- Preserve other filters --}}
            @foreach (request()->except('per_page') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
        </form>

        <div>
            {{ $roles->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css">
    <style>
        body { font-size: 1.1rem; }
        .card { border-radius: 0.5rem; }
        .btn-group.gap-2 .btn { margin-right: 0.5rem; }
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 1rem;
        }
        @media (max-width: 768px) {
            .btn-group { width: 100%; margin-top: 1rem; }
            .btn-group .btn { width: 100%; margin-bottom: 0.5rem; }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        // Initialize datepickers
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true
        });

        // Select all checkbox logic
        document.getElementById('selectAll').addEventListener('change', function () {
            let checkboxes = document.querySelectorAll('.select-item');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        function confirmBulkDelete(event) {
            if (!confirm('Are you sure you want to delete selected roles?')) {
                event.preventDefault();
            } else {
                document.getElementById('bulkDeleteForm').submit();
            }
        }

        function confirmDelete(event) {
            if (!confirm('Are you sure you want to delete this role?')) {
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
@endpush
