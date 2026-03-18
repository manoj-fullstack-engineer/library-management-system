@extends('layouts.admin')

@section('title', 'Authors Management')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
<style>
    .swal2-container {
        align-items: center !important;
        justify-content: center !important;
    }

    .table th, .table td {
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
        <h3 class="mb-0">📚 Authors Management</h3>
    </div>

    <!-- Toolbar: Filters + Actions -->
    <div class="row align-items-center g-2 mb-4 flex-wrap">
        <form id="filter-form" class="col-auto toolbar-form d-flex flex-wrap gap-2" method="GET" action="{{ route('backend.authors.index') }}">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="🔍 Search by Name or Email">
            <button type="submit" class="btn btn-primary">Apply Filters</button>
            <a href="{{ route('backend.authors.index') }}" class="btn btn-secondary">Reset</a>
        </form>

        <div class="col-auto d-flex flex-wrap gap-2">
            @can('create authors')
                <a href="{{ route('backend.authors.create') }}" class="btn btn-success">➕ Add New Author</a>
            @endcan
            @can('export authors')
                <a href="{{ route('backend.authors.excel', request()->query()) }}" class="btn btn-outline-primary">📊 Export Excel</a>
                <a href="{{ route('backend.authors.pdf', request()->query()) }}" class="btn btn-outline-danger">🧾 Export PDF</a>
                <a href="{{ route('backend.authors.print', request()->query()) }}" target="_blank" class="btn btn-outline-secondary">🖨️ Print</a>
            @endcan
            @can('delete authors')
                <button id="bulk-delete-btn" class="btn btn-danger" disabled>🗑️ Delete Selected</button>
            @endcan
        </div>
    </div>

    <!-- Table -->
    <form id="bulk-delete-form" action="{{ route('backend.authors.bulkDelete') }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Country</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($authors as $author)
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="{{ $author->id }}" class="select-item"></td>
                        <td><span class="badge bg-secondary">{{ $author->id }}</span></td>
                        <td>
                            <img src="{{ $author->photo ? asset('storage/' . $author->photo) : asset('images/default-author.png') }}"
                                 alt="Author Photo" class="img-thumbnail" style="width: 60px; height: auto;">
                        </td>
                        <td>{{ $author->name }}</td>
                        <td>{{ $author->email }}</td>
                        <td>{{ $author->phone ?? '—' }}</td>
                        <td>{{ $author->country ?? '—' }}</td>
                        <td class="d-flex gap-1 flex-wrap">
                            @can('view authors')
                                <a href="{{ route('backend.authors.show', $author) }}" class="btn btn-sm btn-info">👁️ Show</a>
                            @endcan
                            @can('edit authors')
                                <a href="{{ route('backend.authors.edit', $author) }}" class="btn btn-sm btn-primary">✏️ Edit</a>
                            @endcan
                            @can('delete authors')
                                <form action="{{ route('backend.authors.destroy', $author) }}" method="POST" class="d-inline delete-single-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-delete-single">🗑️ Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No authors found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>

    <!-- Pagination -->
    @if ($authors instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-3 d-flex justify-content-center">
            {{ $authors->links() }}
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
    $(document).ready(function () {
        $('#select-all').on('change', function () {
            $('.select-item').prop('checked', this.checked);
            toggleBulkDeleteBtn();
        });

        $('.select-item').on('change', function () {
            toggleBulkDeleteBtn();
            $('#select-all').prop('checked', $('.select-item:checked').length === $('.select-item').length);
        });

        function toggleBulkDeleteBtn() {
            $('#bulk-delete-btn').prop('disabled', $('.select-item:checked').length === 0);
        }

        $('#bulk-delete-btn').on('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete selected authors. This action cannot be undone!',
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

        $('.btn-delete-single').on('click', function (e) {
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
