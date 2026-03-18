@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Category Management</h2>
        @can('create categories')
            <a href="{{ route('backend.categories.create') }}" class="btn btn-outline-primary">
                <i class="bi bi-plus-circle"></i> Add New Category
            </a>
        @endcan
    </div>

    {{-- Filter Section --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('backend.categories.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="search" class="form-label">Global Search</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search all fields..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="name" class="form-label">Filter by Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" value="{{ request('name') }}">
                </div>
                <div class="col-md-2">
                    <label for="created_from" class="form-label">Created From</label>
                    <input type="date" name="created_from" id="created_from" class="form-control" value="{{ request('created_from') }}">
                </div>
                <div class="col-md-2">
                    <label for="created_to" class="form-label">Created To</label>
                    <input type="date" name="created_to" id="created_to" class="form-control" value="{{ request('created_to') }}">
                </div>
                <div class="col-md-2 d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i> Search</button>
                    <a href="{{ route('backend.categories.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-circle"></i> Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Pagination (top) --}}
    <div class="d-flex justify-content-end mb-3">
        {{ $categories->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

    {{-- Categories Table --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Category List</h5>
                    @can('delete categories')
                        <form id="bulkDeleteForm" method="POST" action="{{ route('backend.categories.bulkDelete') }}" class="d-flex align-items-center gap-2 mb-0">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="ids" id="bulk-delete-ids">
                            <button type="submit" class="btn btn-danger btn-sm" id="bulkDeleteBtn" disabled>
                                <i class="bi bi-trash-fill me-1"></i> Delete Selected
                            </button>
                        </form>
                    @endcan
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0" id="categoriesTable">
                        <thead class="table-light">
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td><input type="checkbox" class="selectRow" value="{{ $category->id }}"></td>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @can('view categories')
                                                <a href="{{ route('backend.categories.show', $category->id) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                            @endcan
                                            @can('edit categories')
                                                <a href="{{ route('backend.categories.edit', $category->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                            @endcan
                                            @can('delete categories')
                                                <form method="POST" action="{{ route('backend.categories.destroy', $category->id) }}" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-folder-x" style="font-size: 2rem;"></i><br>No categories found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Pagination (bottom) --}}
    <div class="d-flex justify-content-end mt-3">
        {{ $categories->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('#selectAll').on('click', function () {
            $('.selectRow').prop('checked', this.checked);
            $('#bulkDeleteBtn').prop('disabled', !this.checked);
        });

        $('.selectRow').on('change', function () {
            $('#bulkDeleteBtn').prop('disabled', $('.selectRow:checked').length === 0);
        });

        $('.delete-form').on('submit', function (e) {
            e.preventDefault();
            const form = this;
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        $('#bulkDeleteForm').on('submit', function (e) {
            e.preventDefault();
            let ids = $('.selectRow:checked').map(function () { return this.value; }).get();

            if (!ids.length) {
                Swal.fire('Please select at least one category.', '', 'warning');
                return;
            }

            Swal.fire({
                title: 'Delete selected?',
                text: 'This cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#bulk-delete-ids').val(ids.join(','));
                    this.submit();
                }
            });
        });
    });
</script>
@endpush
