@php
    $defaultLogo = asset('images/default-publisher.png');
    $currentLogo = $publisher->logo && $publisher->logo !== 'N/A'
        ? asset('storage/' . $publisher->logo)
        : $defaultLogo;
@endphp

@extends('layouts.admin')

@section('title', 'Edit Publisher')

@section('content')
    <div class="container py-4">
        <div class="card shadow-lg rounded-4 border-0">
            <div class="card-header bg-warning text-dark fw-bold fs-5 rounded-top">
                ✏️ Edit Publisher
            </div>

            <div class="card-body">
                <form action="{{ route('backend.publishers.update', $publisher->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Error Display --}}
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li class="small">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-pill" value="{{ old('name', $publisher->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control rounded-pill" value="{{ old('email', $publisher->email) }}">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" name="phone" class="form-control rounded-pill" value="{{ old('phone', $publisher->phone) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Country</label>
                            <input type="text" name="country" class="form-control rounded-pill" value="{{ old('country', $publisher->country) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address</label>
                        <textarea name="address" class="form-control rounded-3" rows="2">{{ old('address', $publisher->address) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control rounded-3" rows="3">{{ old('description', $publisher->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold d-block">Logo</label>
                        <div class="d-flex align-items-center gap-4">
                            <div>
                                <img id="logo_preview" src="{{ $currentLogo }}" alt="Logo Preview" class="rounded shadow-sm border" style="height: 120px; width: auto;">
                            </div>
                            <div class="flex-grow-1">
                                <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewLogo(event)">
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2">
                            💾 Update Publisher
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Image Preview Script --}}
    <script>
        function previewLogo(event) {
            const [file] = event.target.files;
            if (file) {
                document.getElementById('logo_preview').src = URL.createObjectURL(file);
            }
        }
    </script>
@endsection
