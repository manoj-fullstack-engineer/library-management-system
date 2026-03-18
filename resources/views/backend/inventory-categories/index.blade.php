@extends('layouts.admin')

@section('title', 'Inventory Categories')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-4">📦 Inventory Categories</h1>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Filters --}}
        <form action="{{ route('backend.inventory-categories.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Search by name...">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">-- Filter by Status --</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">🔍 Filter</button>
                <a href="{{ route('backend.inventory-categories.index') }}" class="btn btn-secondary">⟳ Reset</a>
            </div>
        </form>

        {{-- Export & Add New --}}
        {{-- Export & Add New --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('backend.inventory-categories.export.pdf', request()->query()) }}"
                    class="btn btn-danger btn-sm">
                    📄 Export PDF
                </a>
                <a href="{{ route('backend.inventory-categories.export.excel', request()->query()) }}"
                    class="btn btn-success btn-sm">
                    📊 Export Excel
                </a>
                <a href="{{ route('backend.inventory-categories.print', request()->query()) }}" target="_blank"
                    class="btn btn-dark btn-sm">
                    🖨️ Print
                </a>
                <a href="{{ route('backend.inventory-categories.create') }}" class="btn btn-primary btn-sm">
                    ➕ Add New Category
                </a>
            </div>
        </div>



        {{-- Table --}}
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $index => $cat)
                            <tr>
                                <td>{{ $categories->firstItem() + $index }}</td>
                                <td>{{ $cat->name }}</td>
                                <td>{{ Str::limit($cat->description, 50) }}</td>
                                <td>
                                    <span class="badge bg-{{ $cat->status ? 'success' : 'secondary' }}">
                                        {{ $cat->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $cat->created_at->format('d M Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('backend.inventory-categories.edit', $cat->id) }}"
                                        class="btn btn-warning btn-sm">✏️ Edit</a>

                                    <form action="{{ route('backend.inventory-categories.destroy', $cat->id) }}"
                                        method="POST" style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">🗑️ Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No inventory categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $categories->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
