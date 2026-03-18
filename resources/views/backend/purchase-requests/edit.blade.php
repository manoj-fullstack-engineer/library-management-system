{{-- edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Purchase Request')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">✏️ Edit Purchase Request</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('backend.purchase-requests.update', $purchaseRequest) }}" method="POST">
                @csrf
                @method('PUT')
               @include('backend.purchase-requests._form', ['requestData' => $purchaseRequest])

                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save2"></i> Update Request
                    </button>
                    <a href="{{ route('backend.purchase-requests.index') }}" class="btn btn-secondary">Exit</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
