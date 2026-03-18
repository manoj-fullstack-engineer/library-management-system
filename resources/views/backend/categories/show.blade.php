@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Category Details</h4>
        <a href="{{ route('backend.categories.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    @can('view categories')
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <strong>Category Information</strong>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>ID:</strong> {{ $category->id }}
                    </li>
                    <li class="list-group-item">
                        <strong>Name:</strong> {{ $category->name }}
                    </li>
                    <li class="list-group-item">
                        <strong>Created At:</strong> {{ $category->created_at->format('d M Y, h:i A') }}
                    </li>
                    <li class="list-group-item">
                        <strong>Updated At:</strong> {{ $category->updated_at->format('d M Y, h:i A') }}
                    </li>
                </ul>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('backend.categories.index') }}" class="btn btn-secondary">
                    <i class="bi bi-list"></i> Back to List
                </a>
            </div>
        </div>
    @else
        <div class="alert alert-warning mt-4">
            <i class="bi bi-exclamation-triangle-fill me-1"></i>
            You do not have permission to view category details.
        </div>
    @endcan

</div>
@endsection
