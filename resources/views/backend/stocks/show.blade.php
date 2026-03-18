@extends('layouts.admin')

@section('title', 'Stock Details')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4 text-primary"><i class="bi bi-box-seam-fill me-2"></i>Stock Details</h2>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row g-4">

                    {{-- Item Name --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Item Name:</label>
                        <div class="form-control-plaintext border rounded px-3 py-2 bg-light shadow-sm">
                            {{ $stock->item_name }}
                        </div>
                    </div>

                    {{-- Category --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Category:</label>
                        <div class="form-control-plaintext border rounded px-3 py-2 bg-light shadow-sm">
                            {{ $stock->category->name ?? '-' }}
                        </div>
                    </div>

                    {{-- Quantity --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-muted">Quantity:</label>
                        <div class="form-control-plaintext border rounded px-3 py-2 bg-light shadow-sm">
                            {{ $stock->quantity }}
                        </div>
                    </div>

                    {{-- Amount --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-muted">Amount (₹):</label>
                        <div class="form-control-plaintext border rounded px-3 py-2 bg-light shadow-sm">
                            ₹{{ number_format($stock->amount, 2) }}
                        </div>
                    </div>

                    {{-- Vendor --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-muted">Vendor:</label>
                        <div class="form-control-plaintext border rounded px-3 py-2 bg-light shadow-sm">
                            {{ $stock->vendor ?? '-' }}
                        </div>
                    </div>

                    {{-- Bill File --}}
                    <div class="col-md-12">
                        <label class="form-label fw-semibold text-muted">Bill File:</label>
                        @if ($stock->bill_file_path)
                            @php
                                $fileUrl = route('backend.stocks.viewBill', $stock->id);
                                $extension = strtolower(pathinfo($stock->bill_file_path, PATHINFO_EXTENSION));
                            @endphp

                            <div class="mt-2">
                                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                    <img src="{{ $fileUrl }}" class="img-thumbnail shadow-sm"
                                        style="max-height: 250px; cursor: pointer;" data-bs-toggle="modal"
                                        data-bs-target="#billModal" alt="Bill Image">
                                @elseif ($extension === 'pdf')
                                    <embed src="{{ $fileUrl }}" type="application/pdf" class="w-100 border rounded shadow-sm"
                                        height="350px" />
                                    <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-dark mt-2">
                                        <i class="bi bi-arrows-fullscreen me-1"></i>Open Fullscreen
                                    </a>
                                @else
                                    <p class="text-muted">Unsupported file type</p>
                                @endif
                            </div>
                        @else
                            <div class="form-control-plaintext text-muted">No file uploaded</div>
                        @endif
                    </div>

                    {{-- Remarks --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Remarks:</label>
                        <div class="form-control-plaintext border rounded px-3 py-2 bg-light shadow-sm">
                            {{ $stock->remark ?? '-' }}
                        </div>
                    </div>

                    {{-- Created By --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Created By:</label>
                        <div class="form-control-plaintext border rounded px-3 py-2 bg-light shadow-sm">
                            {{ $stock->creator->name ?? 'System' }}
                        </div>
                    </div>

                    {{-- Created At --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Created At:</label>
                        <div class="form-control-plaintext border rounded px-3 py-2 bg-light shadow-sm">
                            {{ $stock->created_at->format('d M Y h:i A') }}
                        </div>
                    </div>

                </div>

                <div class="mt-5 text-center">
                    <a href="{{ route('backend.stocks.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left-circle me-1"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Fullscreen Modal for Bill Image --}}
    @if ($stock->bill_file_path && in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
        <div class="modal fade" id="billModal" tabindex="-1" aria-labelledby="billModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-body p-0 text-center">
                        <img src="{{ $fileUrl }}" class="img-fluid w-100" alt="Bill Fullscreen">
                    </div>
                    <div class="modal-footer bg-dark justify-content-between">
                        <span>🖼 Fullscreen Bill Preview</span>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
