@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    {{-- Breadcrumbs --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            {{-- <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li> --}}
            <li class="breadcrumb-item"><a href="{{ route('backend.roles.index') }}">Roles</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $role->name }}</li>
        </ol>
    </nav>

    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h2 mb-0">
                    <i class="fas fa-user-tag me-2"></i>Role Details: {{ $role->name }}
                </h1>
                <div>
                    <a href="{{ route('backend.roles.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Roles
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="fw-bold text-primary mb-3">
                            <i class="fas fa-info-circle me-2"></i>Basic Information
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Role Name:</strong> {{ $role->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Guard Name:</strong> {{ $role->guard_name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Users with this role:</strong> {{ $userCount }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Created At:</strong> {{ $role->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Updated At:</strong> {{ $role->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-bold text-primary mb-3">
                            <i class="fas fa-key me-2"></i>Assigned Permissions
                        </h5>
                        
                        @if(count($rolePermissions) > 0)
                            <div class="row g-2">
                                @foreach($permissions as $permission)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               id="perm_{{ $permission->id }}"
                                               disabled
                                               @if(in_array($permission->id, $rolePermissions)) checked @endif>
                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            {{ ucwords(str_replace('.', ' ', $permission->name)) }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                No permissions assigned to this role.
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-4">
                        <a href="{{ route('backend.roles.edit', $role->id) }}" class="btn btn-warning px-4">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <form action="{{ route('backend.roles.destroy', $role->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger px-4" 
                                    onclick="return confirm('Are you sure you want to delete this role?')">
                                <i class="fas fa-trash-alt me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection