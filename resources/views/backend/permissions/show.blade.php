@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">View Permission Details</h1>
        <a href="{{ route('backend.permissions.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    {{-- Permission Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-shield-alt me-2"></i> Permission Information</h5>
        </div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3 text-muted">Permission Name:</dt>
                <dd class="col-sm-9">{{ $permission->name }}</dd>

                <dt class="col-sm-3 text-muted">Guard Name:</dt>
                <dd class="col-sm-9">{{ $permission->guard_name }}</dd>

                <dt class="col-sm-3 text-muted">Created At:</dt>
                <dd class="col-sm-9">{{ $permission->created_at->format('d/m/Y') }}</dd>

                <dt class="col-sm-3 text-muted">Updated At:</dt>
                <dd class="col-sm-9">{{ $permission->updated_at->format('d/m/Y') }}</dd>
            </dl>
        </div>
        <div class="card-footer bg-light d-flex justify-content-end">
            <a href="{{ route('backend.permissions.edit', $permission->id) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <form action="{{ route('backend.permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('Delete this permission?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash-alt me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
