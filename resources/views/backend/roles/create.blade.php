@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-user-shield me-2"></i>Create New Role</h5>
                    <a href="{{ route('backend.roles.index') }}" class="btn btn-sm btn-light text-dark">
                        <i class="fas fa-arrow-left me-1"></i> Back to Roles
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.roles.store') }}" method="POST">
                        @csrf

                        {{-- Role Name --}}
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">Role Name</label>
                            <input type="text" name="name" id="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" placeholder="e.g. Editor, Admin" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Permissions --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Assign Permissions</label>
                            <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                <div class="row">
                                    @forelse ($permissions as $permission)
                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="permissions[]" value="{{ $permission->id }}"
                                                       id="permission_{{ $permission->id }}"
                                                       {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                    <span class="badge bg-light text-dark border">
                                                        {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-muted">No permissions found.</div>
                                    @endforelse
                                </div>
                            </div>
                            @error('permissions')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backend.roles.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-success text-white">
                                <i class="fas fa-save me-1"></i> Create Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
