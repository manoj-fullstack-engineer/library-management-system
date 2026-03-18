@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Edit Category</h4>
        <a href="{{ route('backend.categories.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    @can('edit categories')
        <form method="POST" action="{{ route('backend.categories.update', $category->id) }}" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <strong>Category Information</strong>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $category->name) }}"
                            placeholder="Enter category name"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Update Category
                    </button>
                    <a href="{{ route('backend.categories.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </div>
        </form>
    @else
        <div class="alert alert-warning mt-4">
            <i class="bi bi-exclamation-triangle-fill me-1"></i>
            You do not have permission to edit categories.
        </div>
    @endcan

</div>
@endsection
