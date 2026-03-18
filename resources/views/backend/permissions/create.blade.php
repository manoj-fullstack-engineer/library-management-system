@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Add New Permission</h5>
                </div>
                <div class="card-body">
                    <!-- Displaying error message if permission already exists -->
                    @if ($errors->has('name'))
                        <div class="d-flex justify-content-center mb-4">
                            <div class="alert alert-danger text-center w-100">
                                <strong><i class="fas fa-exclamation-triangle me-1"></i> The permission is already created.</strong>
                            </div>
                        </div>
                    @endif
                    
                    <form action="{{ route('backend.permissions.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Permission Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter permission name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('backend.permissions.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Create Permission</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
