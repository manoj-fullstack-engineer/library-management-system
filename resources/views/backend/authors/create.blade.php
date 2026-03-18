@php
    $defaultImage = asset('storage/authors/default-author.png'); // public/storage/authors/default-author.png
@endphp

@extends('layouts.admin')

@section('title', 'Add New Author')

@section('content')
<div class="container">
    <div class="card shadow rounded">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Add New Author</h4>
            <a href="{{ route('backend.authors.index') }}" class="btn btn-light btn-sm">← Back to List</a>
        </div>

        <div class="card-body">
            <form action="{{ route('backend.authors.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="row g-3">

                    {{-- Name --}}
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Author full name" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="Author email address" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-bold">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                               class="form-control @error('phone') is-invalid @enderror"
                               placeholder="Mobile number">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Country --}}
                    <div class="col-md-6">
                        <label for="country" class="form-label fw-bold">Country</label>
                        <input type="text" name="country" id="country" value="{{ old('country') }}"
                               class="form-control @error('country') is-invalid @enderror"
                               placeholder="Author's country">
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Photo Upload & Preview --}}
                    <div class="col-md-6 text-center">
                        <label for="photo" class="form-label fw-bold">Author Photo</label>

                        <div class="position-relative d-inline-block">
                            <img id="photo_preview" src="{{ $defaultImage }}" alt="Photo Preview"
                                 class="img-thumbnail mb-2"
                                 style="max-height: 200px; object-fit: contain;">
                            <span id="photo_na_label"
                                  class="position-absolute top-50 start-50 translate-middle text-muted fw-bold"
                                  style="font-size: 1.5rem;">N/A</span>
                        </div>

                        <input type="file" name="photo" id="photo" accept="image/*"
                               class="form-control @error('photo') is-invalid @enderror">
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Max 100KB. Will be compressed automatically.</small>
                    </div>

                    {{-- Biography --}}
                    <div class="col-md-12">
                        <label for="biography" class="form-label fw-bold">Biography</label>
                        <textarea name="biography" id="biography" rows="4"
                                  class="form-control @error('biography') is-invalid @enderror"
                                  placeholder="Short biography or notes">{{ old('biography') }}</textarea>
                        @error('biography')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success">Save Author</button>
                        <a href="{{ route('backend.authors.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const photoInput = document.getElementById('photo');
        const photoPreview = document.getElementById('photo_preview');
        const naLabel = document.getElementById('photo_na_label');

        const defaultImage = @json($defaultImage);

        photoInput.addEventListener('change', function () {
            const file = this.files[0];

            if (!file) {
                photoPreview.src = defaultImage;
                naLabel.style.display = 'block';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                photoPreview.src = e.target.result;
                naLabel.style.display = 'none';
            };
            reader.readAsDataURL(file);
        });

        // Show "N/A" if default image
        if (photoPreview.src.includes('default-author.png')) {
            naLabel.style.display = 'block';
        }
    });
</script>
@endpush
