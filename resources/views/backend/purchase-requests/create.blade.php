{{-- create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Add Purchase Request')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">➕ Add Purchase Request</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('backend.purchase-requests.store') }}" method="POST">
                 @csrf
                @include('backend.purchase-requests._form', ['requestData' => null])
                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Save Request
                    </button>
                    <a href="{{ route('backend.purchase-requests.index') }}" class="btn btn-secondary">Exit</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
