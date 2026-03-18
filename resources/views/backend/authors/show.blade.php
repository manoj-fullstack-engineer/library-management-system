@php
    $defaultImage = asset('images/default-author.png');
    $photo = $author->photo ? asset('storage/' . $author->photo) : $defaultImage;
@endphp

@extends('layouts.admin')

@section('title', 'View Author')

@section('content')
<div class="container">
    <div class="card shadow rounded">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Author Details</h4>
            <a href="{{ route('backend.authors.index') }}" class="btn btn-light btn-sm">← Back to List</a>
        </div>

        <div class="card-body row g-4">

            <div class="col-md-4 text-center">
                <img src="{{ $photo }}" alt="Author Photo" class="img-thumbnail w-100" style="max-height: 300px;">
            </div>

            <div class="col-md-8">
                <dl class="row mb-0">
                    <dt class="col-sm-4 fw-bold">Name:</dt>
                    <dd class="col-sm-8">{{ $author->name }}</dd>

                    <dt class="col-sm-4 fw-bold">Email:</dt>
                    <dd class="col-sm-8">{{ $author->email ?? '—' }}</dd>

                    <dt class="col-sm-4 fw-bold">Phone:</dt>
                    <dd class="col-sm-8">{{ $author->phone ?? '—' }}</dd>

                    <dt class="col-sm-4 fw-bold">Country:</dt>
                    <dd class="col-sm-8">{{ $author->country ?? '—' }}</dd>

                    <dt class="col-sm-4 fw-bold">Biography:</dt>
                    <dd class="col-sm-8">
                        {!! $author->biography ? nl2br(e($author->biography)) : '—' !!}
                    </dd>
                </dl>
            </div>

        </div>

        <div class="card-footer text-end">
            <a href="{{ route('backend.authors.edit', $author->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('backend.authors.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
