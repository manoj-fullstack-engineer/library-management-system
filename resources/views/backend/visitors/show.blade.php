@extends('backend.layouts.app')

@section('title', 'Visitor Details')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title">Visitor Details</h3>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Name:</dt>
            <dd class="col-sm-9">{{ $visitor->name }}</dd>

            <dt class="col-sm-3">Email:</dt>
            <dd class="col-sm-9">{{ $visitor->email ?? '—' }}</dd>

            <dt class="col-sm-3">Phone:</dt>
            <dd class="col-sm-9">{{ $visitor->phone ?? '—' }}</dd>

            <dt class="col-sm-3">IP Address:</dt>
            <dd class="col-sm-9">{{ $visitor->ip_address ?? '—' }}</dd>

            <dt class="col-sm-3">Visited At:</dt>
            <dd class="col-sm-9">{{ optional($visitor->visited_at)->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Created At:</dt>
            <dd class="col-sm-9">{{ $visitor->created_at->format('d/m/Y') }}</dd>
        </dl>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <a href="{{ route('backend.visitors.index') }}" class="btn btn-secondary me-2">Back</a>
        <a href="{{ route('backend.visitors.edit', $visitor->id) }}" class="btn btn-primary">Edit</a>
    </div>
</div>
@endsection
