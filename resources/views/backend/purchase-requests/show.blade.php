@extends('layouts.admin')

@section('title', 'Purchase Request Details')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary"><i class="bi bi-journal-text me-2"></i>Purchase Request Details</h2>
    </div>

    <div class="card border-0 shadow rounded-4">
        <div class="card-body px-5 py-4">
            <div class="row g-4">

                {{-- Request Number --}}
                <div class="col-md-6">
                    <label class="form-label text-muted"><i class="bi bi-hash"></i> Request Number</label>
                    <div class="fs-5 fw-semibold text-dark">{{ $purchaseRequest->request_number }}</div>
                </div>

                {{-- Item Name --}}
                <div class="col-md-6">
                    <label class="form-label text-muted"><i class="bi bi-book"></i> Item Name</label>
                    <div class="fs-5 text-dark">{{ $purchaseRequest->item_name }}</div>
                </div>

                {{-- Author --}}
                <div class="col-md-4">
                    <label class="form-label text-muted"><i class="bi bi-person-lines-fill"></i> Author</label>
                    <div>{{ $purchaseRequest->author ?? '—' }}</div>
                </div>

                {{-- Publisher --}}
                <div class="col-md-4">
                    <label class="form-label text-muted"><i class="bi bi-building"></i> Publisher</label>
                    <div>{{ $purchaseRequest->publisher ?? '—' }}</div>
                </div>

                {{-- ISBN --}}
                <div class="col-md-4">
                    <label class="form-label text-muted"><i class="bi bi-upc-scan"></i> ISBN</label>
                    <div>{{ $purchaseRequest->isbn ?? '—' }}</div>
                </div>

                {{-- Category --}}
                <div class="col-md-6">
                    <label class="form-label text-muted"><i class="bi bi-tags"></i> Category</label>
                    <div>{{ $purchaseRequest->category->name ?? '—' }}</div>
                </div>

                {{-- Quantity --}}
                <div class="col-md-3">
                    <label class="form-label text-muted"><i class="bi bi-stack"></i> Quantity</label>
                    <div>{{ $purchaseRequest->quantity }}</div>
                </div>

                {{-- Estimated Cost --}}
                <div class="col-md-3">
                    <label class="form-label text-muted"><i class="bi bi-currency-rupee"></i> Estimated Cost</label>
                    <div>₹{{ number_format($purchaseRequest->estimated_cost, 2) }}</div>
                </div>

                {{-- Status --}}
                <div class="col-md-4">
                    <label class="form-label text-muted"><i class="bi bi-info-circle"></i> Status</label>
                    <div>
                        <span class="badge bg-{{ 
                            $purchaseRequest->status === 'approved' ? 'success' : 
                            ($purchaseRequest->status === 'rejected' ? 'danger' : 
                            ($purchaseRequest->status === 'ordered' ? 'warning' : 
                            ($purchaseRequest->status === 'received' ? 'primary' : 'secondary'))) 
                        }} px-3 py-2 rounded-pill text-uppercase shadow-sm">
                            {{ ucfirst($purchaseRequest->status) }}
                        </span>
                    </div>
                </div>

                {{-- Requested By --}}
                <div class="col-md-4">
                    <label class="form-label text-muted"><i class="bi bi-person-circle"></i> Requested By</label>
                    <div>{{ $purchaseRequest->requester->name ?? '—' }}</div>
                </div>

                {{-- Request Date --}}
                <div class="col-md-4">
                    <label class="form-label text-muted"><i class="bi bi-calendar-event"></i> Request Date</label>
                    <div>{{ $purchaseRequest->created_at->format('d M Y, h:i A') }}</div>
                </div>

                {{-- Remark --}}
                <div class="col-12">
                    <label class="form-label text-muted"><i class="bi bi-chat-left-dots"></i> Remark</label>
                    <div class="p-3 bg-light border rounded">
                        {!! $purchaseRequest->remark ? nl2br(e($purchaseRequest->remark)) : 'No remarks provided.' !!}
                    </div>
                </div>
            </div>

            <div class="text-end mt-4 text-center">
                <a href="{{ route('backend.purchase-requests.index') }}" class="btn btn-outline-secondary rounded-pill shadow-sm">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
