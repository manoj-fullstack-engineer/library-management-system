@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-primary fw-bold">Edit Enquiry</h4>
                <a href="{{ route('backend.enquiries.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back to List
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('backend.enquiries.update', $enquiry->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ $enquiry->name }}" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ $enquiry->email }}" class="form-control"
                                required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" class="form-control" value="{{ $enquiry->phone }}" name="phone"
                                id="phone-field" required="" maxlength="10" pattern="\d{10}" inputmode="numeric"
                                title="Enter a 10-digit phone number">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                            <input type="text" name="subject" value="{{ $enquiry->subject }}" class="form-control"
                                required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control" rows="4" required>{{ $enquiry->message }}</textarea>
                    </div>

                    <div class="d-grid d-md-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle me-1"></i> Update Enquiry
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
