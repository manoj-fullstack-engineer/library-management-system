@php
    $defaultLogo = asset('images/default-publisher.png');
@endphp

@extends('layouts.admin')

@section('title', 'Add New Publisher')

@section('content')
    <div class="container py-4">
        <div class="card shadow-lg rounded-4 border-0">
            <div class="card-header bg-primary text-white fw-bold fs-5 rounded-top">
                ➕ Add New Publisher
            </div>

            <div class="card-body">
                <form action="{{ route('backend.publishers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

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
                            <input type="text" name="name" class="form-control rounded-pill" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control rounded-pill" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" name="phone" class="form-control rounded-pill" value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Country</label>
                            <input type="text" name="country" class="form-control rounded-pill" value="{{ old('country') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address</label>
                        <textarea name="address" class="form-control rounded-3" rows="2">{{ old('address') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control rounded-3" rows="3">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold d-block">Logo</label>
                        <div class="d-flex align-items-center gap-4">
                            <div>
                                <img id="logo_preview" src="{{ $defaultLogo }}" alt="Logo Preview" class="rounded shadow-sm border" style="height: 120px; width: auto;">
                            </div>
                            <div class="flex-grow-1">
                                <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewLogo(event)">
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success rounded-pill px-4 py-2">
                            💾 Save Publisher
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
