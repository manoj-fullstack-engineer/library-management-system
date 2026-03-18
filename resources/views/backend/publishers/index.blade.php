@extends('layouts.admin')

@section('title', 'Publishers Management')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
    <style>
        .swal2-container {
            align-items: center !important;
            justify-content: center !important;
        }

        .table th,
        .table td {
            vertical-align: middle !important;
        }

        .toolbar-form .form-control {
            min-width: 220px;
        }

        .table img {
            border: 2px solid #dee2e6;
            border-radius: 0.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">🏢 Publishers Management</h3>
        </div>

<div class="row align-items-center g-2 mb-4 flex-wrap">
    <form id="filter-form" class="col-auto toolbar-form d-flex align-items-center gap-2 flex-grow-1" method="GET"
        action="{{ route('backend.publishers.index') }}">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
            placeholder="🔍 Search by Name or Email">
        <button type="submit" class="btn btn-primary">Apply</button>
        <a href="{{ route('backend.publishers.index') }}" class="btn btn-secondary">Reset</a>
    </form>

    <div class="col-auto d-flex flex-wrap gap-2 ms-auto">
        @can('create publishers')
            <a href="{{ route('backend.publishers.create') }}" class="btn btn-success">➕ Add New Publisher</a>
        @endcan
        @can('export publishers')
            <a href="{{ route('backend.publishers.excel', request()->query()) }}" class="btn btn-outline-primary">📊 Export Excel</a>
            <a href="{{ route('backend.publishers.pdf', request()->query()) }}" class="btn btn-outline-danger">🧾 Export PDF</a>
            <a href="{{ route('backend.publishers.print', request()->query()) }}" target="_blank" class="btn btn-outline-secondary">🖨️ Print</a>
        @endcan
        @can('delete publishers')
            <button id="bulk-delete-btn" class="btn btn-danger" disabled>🗑️ Delete Selected</button>
        @endcan
    </div>
</div>


        <form id="bulk-delete-form" action="{{ route('backend.publishers.bulkDelete') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>ID</th>
                            <th>Logo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Country</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($publishers as $publisher)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $publisher->id }}" class="select-item">
                                </td>
                                <td><span class="badge bg-secondary">{{ $publisher->id }}</span></td>
                                <td>
                                    <img src="{{ $publisher->logo ? asset('storage/' . $publisher->logo) : asset('images/default-publisher.png') }}"
                                        alt="Publisher Logo" class="img-thumbnail" style="width: 60px; height: auto;">
                                </td>
                                <td>{{ $publisher->name }}</td>
                                <td>{{ $publisher->email }}</td>
                                <td>{{ $publisher->phone ?? '—' }}</td>
                                <td>{{ $publisher->country ?? '—' }}</td>
                                <td class="d-flex gap-1 flex-wrap">
                                    @can('view publishers')
                                        <a href="{{ route('backend.publishers.show', $publisher) }}"
                                            class="btn btn-sm btn-info">👁️ Show</a>
                                    @endcan
                                    @can('edit publishers')
                                        <a href="{{ route('backend.publishers.edit', $publisher) }}"
                                            class="btn btn-sm btn-primary">✏️ Edit</a>
                                    @endcan
                                    @can('delete publishers')
                                        <form action="{{ route('backend.publishers.destroy', $publisher) }}" method="POST"
                                            class="d-inline delete-single-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete-single">🗑️
                                                Delete</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No publishers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        @if ($publishers instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-3 d-flex justify-content-center">
                {{ $publishers->links() }}
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#select-all').on('change', function() {
                $('.select-item').prop('checked', this.checked);
                toggleBulkDeleteBtn();
            });

            $('.select-item').on('change', function() {
                toggleBulkDeleteBtn();
                $('#select-all').prop('checked', $('.select-item:checked').length === $('.select-item')
                    .length);
            });

            function toggleBulkDeleteBtn() {
                $('#bulk-delete-btn').prop('disabled', $('.select-item:checked').length === 0);
            }

            $('#bulk-delete-btn').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to delete selected publishers. This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete them!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#bulk-delete-form').submit();
                    }
                });
            });

            $('.btn-delete-single').on('click', function(e) {
                e.preventDefault();
                const form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
