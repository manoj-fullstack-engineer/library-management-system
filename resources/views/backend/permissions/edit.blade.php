@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Edit Permission</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.permissions.update', $permission->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Permission Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $permission->name }}" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('backend.permissions.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-warning">Update Permission</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection