@extends('layouts.admin')

@section('title', 'View Publisher')

@section('content')
<div class="container">
    <div class="card shadow rounded">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Publisher Details</h3>
            <a href="{{ route('backend.publishers.index') }}" class="btn btn-secondary">← Back to List</a>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4 text-center">
                    <img src="{{ $publisher->logo ? asset('storage/' . $publisher->logo) : asset('images/default-publisher.png') }}" 
                         alt="Publisher Logo" class="img-thumbnail" style="max-width: 250px;">
                </div>
                <div class="col-md-8">
                    <h4>{{ $publisher->name }}</h4>
                    <p><strong>Email:</strong> {{ $publisher->email ?? '—' }}</p>
                    <p><strong>Phone:</strong> {{ $publisher->phone ?? '—' }}</p>
                    <p><strong>Address:</strong> {{ $publisher->address ?? '—' }}</p>
                    <p><strong>Country:</strong> {{ $publisher->country ?? '—' }}</p>
                    <p><strong>Description:</strong></p>
                    <p>{{ $publisher->description ?? 'No description provided.' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
