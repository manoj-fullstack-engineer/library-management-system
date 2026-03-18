@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    {{-- Toast Notification --}}
    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="h3">Permission Management</h1>
        <div class="btn-group flex-wrap">
            <a href="{{ route('backend.permissions.export.filtered.pdf', request()->query()) }}" class="btn btn-outline-danger">
                <i class="fas fa-file-pdf me-1"></i> Export PDF
            </a>
            <a href="{{ route('backend.permissions.export.filtered.excel', request()->query()) }}" class="btn btn-outline-success">
                <i class="fas fa-file-excel me-1"></i> Export Excel
            </a>
            <button onclick="printTable()" class="btn btn-outline-secondary">
                <i class="fas fa-print me-1"></i> Print
            </button>
            <a href="{{ route('backend.permissions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New Permission
            </a>
        </div>
    </div>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('backend.permissions.index') }}" class="card card-body mb-4 shadow-sm">
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-2">
            <div style="flex: 1 1 20%;">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by Permission Name">
            </div>
            <div style="flex: 1 1 15%;">
                <input type="text" name="start_date" value="{{ request('start_date') }}" class="form-control datepicker" placeholder="From Date" autocomplete="off">
            </div>
            <div style="flex: 1 1 15%;">
                <input type="text" name="end_date" value="{{ request('end_date') }}" class="form-control datepicker" placeholder="To Date" autocomplete="off">
            </div>
            <div style="flex: 1 1 15%;">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="fas fa-filter me-1"></i> Apply
                </button>
            </div>
            <div style="flex: 1 1 15%;">
                <a href="{{ route('backend.permissions.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-list me-1"></i> Show All
                </a>
            </div>
        </div>
    </form>

    {{-- Permissions Table --}}
    <form method="POST" action="{{ route('backend.permissions.bulk-delete') }}" id="bulkDeleteForm">
        @csrf
        @method('DELETE')
        <div class="card shadow-sm">
            <div class="card-body table-responsive p-0">
                <div class="mb-3">
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmBulkDelete(event)">
                        <i class="fas fa-trash-alt me-1"></i> Delete Selected
                    </button>
                </div>

                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 30px;"><input type="checkbox" id="selectAll"></th>
                            <th style="width: 50px;">#</th>
                            <th>Permission Name</th>
                            <th>Guard</th>
                            <th style="width: 120px;">Created At</th>
                            <th class="text-center" style="width: 170px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permissions as $index => $permission)
                            <tr>
                                <td><input type="checkbox" name="selected_permissions[]" value="{{ $permission->id }}" class="select-item"></td>
                                <td>{{ $permissions->firstItem() + $index }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->guard_name }}</td>
                                <td>{{ $permission->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('backend.permissions.show', $permission->id) }}" class="btn btn-sm btn-info" title="Show">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('backend.permissions.edit', $permission->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('backend.permissions.destroy', $permission->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this permission?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No permissions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    {{-- Pagination & Per Page --}}
    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
        <form method="GET" class="d-flex align-items-center gap-2">
            <label for="per_page" class="mb-0">Show</label>
            <select name="per_page" id="per_page" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                @php $perPageOptions = [10, 20, 50, 100, 'all']; @endphp
                @foreach ($perPageOptions as $option)
                    <option value="{{ $option }}" {{ request('per_page', 10) == $option ? 'selected' : '' }}>
                        {{ ucfirst($option) }}
                    </option>
                @endforeach
            </select>
            <span class="mb-0">records</span>

            {{-- Preserve filters --}}
            <input type="hidden" name="search" value="{{ request('search') }}">
            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
        </form>

        <div>
            {{ $permissions->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
    <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" />
@endpush

@push('scripts')
    <!-- jQuery (needed for datepicker and ajax) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function() {
            // Initialize datepicker inputs
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true
            });

            // Select All checkbox toggle
            $('#selectAll').on('change', function() {
                $('.select-item').prop('checked', this.checked);
            });

            // Update Select All checkbox status on individual checkbox change
            $(document).on('change', '.select-item', function() {
                const allChecked = $('.select-item:checked').length === $('.select-item').length;
                $('#selectAll').prop('checked', allChecked);
            });
        });

        function confirmBulkDelete(event) {
            event.preventDefault();
            const selected = $('input[name="selected_permissions[]"]:checked').map(function() {
                return $(this).val();
            }).get();

            if (selected.length === 0) {
                Swal.fire('No Selection', 'Please select at least one permission to delete.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: 'Selected permissions will be permanently deleted!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('backend.permissions.bulk-delete') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            selected_permissions: selected
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', response.message, 'success');
                            setTimeout(() => location.reload(), 1500);
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            Swal.fire('Error', 'Failed to delete selected permissions.', 'error');
                        }
                    });
                }
            });
        }

        function printTable() {
            const printWindow = window.open('', '', 'height=600,width=800');
            const table = $('table').first().clone();

            // Remove checkbox and actions columns for printing
            table.find('th:first-child, td:first-child').remove();
            table.find('th:last-child, td:last-child').remove();

            const header = `
                <h2>Permissions Report</h2>
                <p><strong>Search:</strong> {{ request('search') ?? 'None' }}</p>
                <p><strong>From Date:</strong> {{ request('start_date') ?? 'None' }}</p>
                <p><strong>To Date:</strong> {{ request('end_date') ?? 'None' }}</p>
                <hr>
            `;

            printWindow.document.write('<html><head><title>Print Permissions</title>');
            printWindow.document.write('<style>body { font-family: Arial, sans-serif; } table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid #ddd; padding: 8px; } th { background-color: #f2f2f2; }</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(header);
            printWindow.document.write(table.prop('outerHTML'));
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
@endpush
