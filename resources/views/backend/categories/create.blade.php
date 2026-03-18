@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Add New Category</h4>
        <a href="{{ route('backend.categories.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    @can('create categories')
        <form method="POST" action="{{ route('backend.categories.store') }}" class="needs-validation" novalidate>
            @csrf

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <strong>Category Details</strong>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Enter category name"
                            value="{{ old('name') }}"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Save Category
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
            You do not have permission to create categories.
        </div>
    @endcan
</div>
@endsection
