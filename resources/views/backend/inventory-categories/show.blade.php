@extends('layouts.admin')

@section('title', 'Category Details')

@section('content')
<div class="container">
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">📁 Category Details</h4>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Name</dt>
                <dd class="col-sm-9">{{ $inventoryCategory->name }}</dd>

                <dt class="col-sm-3">Description</dt>
                <dd class="col-sm-9">{{ $inventoryCategory->description ?? '—' }}</dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">
                    <span class="badge bg-{{ $inventoryCategory->status ? 'success' : 'secondary' }}">
                        {{ $inventoryCategory->status ? 'Active' : 'Inactive' }}
                    </span>
                </dd>

                <dt class="col-sm-3">Created At</dt>
                <dd class="col-sm-9">{{ $inventoryCategory->created_at->format('d M Y, h:i A') }}</dd>
            </dl>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('backend.inventory-categories.index') }}" class="btn btn-secondary">⬅️ Back to List</a>
        </div>
    </div>
</div>
@endsection
