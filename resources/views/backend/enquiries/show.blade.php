@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Enquiry Details</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $enquiry->name }}</p>
            <p><strong>Email:</strong> {{ $enquiry->email }}</p>
            <p><strong>Phone:</strong> {{ $enquiry->phone }}</p>
            <p><strong>Status:</strong> {{ $enquiry->status }}</p>
            <p><strong>Message:</strong><br>{{ $enquiry->message }}</p>
            <p><strong>Created At:</strong> {{ $enquiry->created_at->format('Y-m-d H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('backend.enquiries.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
