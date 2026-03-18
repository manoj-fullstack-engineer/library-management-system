@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow rounded-3">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Create New Enquiry</h4>
                        <a href="{{ route('backend.enquiries.index') }}" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-arrow-left-circle"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.enquiries.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" required placeholder="Enter your full name">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" required placeholder="Enter your email">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" id="phone-field"
                                        required="" maxlength="10" pattern="\d{10}" inputmode="numeric"
                                        title="Enter a 10-digit phone number">
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="subject" id="subject" required placeholder="Enter subject">
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="message" id="message" rows="4" required placeholder="Enter your message here..."></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Submit Enquiry
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
