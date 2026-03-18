@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow border-0">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-primary">👤 User Profile: <strong>{{ $user->name }}</strong></h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('backend.users.edit', $user->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('backend.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to User List
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row g-4">
                    <!-- Basic Information -->
                    <div class="col-md-6">
                        <div class="border rounded p-3 h-100 bg-light">
                            <h5 class="text-secondary mb-3">📄 Basic Information</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-3">
                                    <strong class="d-block text-dark">Name:</strong>
                                    <span class="text-muted">{{ $user->name }}</span>
                                </li>
                                <li class="mb-3">
                                    <strong class="d-block text-dark">Email:</strong>
                                    <span class="text-muted">{{ $user->email }}</span>
                                </li>
                                <li>
                                    <strong class="d-block text-dark">Created At:</strong>
                                    <span class="text-muted">{{ $user->created_at->format('d M Y, h:i A') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Roles & Permissions -->
                    <div class="col-md-6">
                        <div class="border rounded p-3 h-100 bg-light">
                            <h5 class="text-secondary mb-3">🔐 Roles & Permissions</h5>
                            <div class="mb-3">
                                <strong class="d-block text-dark mb-2">Roles:</strong>
                                @forelse($user->roles as $role)
                                    <span class="badge bg-primary me-1 mb-1">{{ $role->name }}</span>
                                @empty
                                    <span class="text-muted">No roles assigned</span>
                                @endforelse
                            </div>
                            <div>
                                <strong class="d-block text-dark mb-2">Permissions:</strong>
                                @forelse($user->getAllPermissions() as $permission)
                                    <span class="badge bg-success me-1 mb-1">{{ $permission->name }}</span>
                                @empty
                                    <span class="text-muted">No permissions assigned</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
