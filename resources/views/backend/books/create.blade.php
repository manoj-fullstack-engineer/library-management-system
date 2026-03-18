@php
    $defaultImage = asset('images/default-book.png'); // Ensure this default image exists in public/images/
@endphp

@extends('layouts.admin')

@section('title', 'Add New Book')

@section('content')
    <div class="container">
        <div class="card shadow rounded">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Add New Book</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('backend.books.store') }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="row g-3">
                        {{-- Title & Author --}}
                        <div class="col-md-6">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input id="title" type="text" name="title" value="{{ old('title') }}" required
                                class="form-control @error('title') is-invalid @enderror" autofocus>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="author" class="form-label">Author <span class="text-danger">*</span></label>
                            <input id="author" type="text" name="author" value="{{ old('author') }}" required
                                class="form-control @error('author') is-invalid @enderror">
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ISBN & Publisher --}}
                        <div class="col-md-6">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input id="isbn" type="text" name="isbn" value="{{ old('isbn') }}"
                                class="form-control @error('isbn') is-invalid @enderror">
                            @error('isbn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="publisher" class="form-label">Publisher</label>
                            <input id="publisher" type="text" name="publisher" value="{{ old('publisher') }}"
                                class="form-control @error('publisher') is-invalid @enderror">
                            @error('publisher')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Published Date & Category --}}
                        <div class="col-md-6">
                            <label for="published_date" class="form-label">Published Date</label>
                            <input id="published_date" type="text" name="published_date"
                                value="{{ old('published_date') }}"
                                class="form-control @error('published_date') is-invalid @enderror" placeholder="dd/mm/yyyy">
                            @error('published_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id"
                                class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">Select Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Language & Pages --}}
                        <div class="col-md-6">
                            <label for="language" class="form-label">Language</label>
                            <input id="language" type="text" name="language" value="{{ old('language') }}"
                                class="form-control @error('language') is-invalid @enderror">
                            @error('language')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="pages" class="form-label">Pages</label>
                            <input id="pages" type="number" name="pages" value="{{ old('pages') }}" min="1"
                                class="form-control @error('pages') is-invalid @enderror">
                            @error('pages')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price</label>
                            <input id="price" type="number" name="price" value="{{ old('price', '0.00') }}"
                                min="0.00" step="0.01" class="form-control @error('price') is-invalid @enderror">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- Status --}}
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select id="status" name="status"
                                class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">Select Status</option>
                                @foreach (['available', 'issued', 'damaged', 'lost'] as $status)
                                    <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <input id="description" type="text" name="description" value="{{ old('description') }}"
                                class="form-control @error('description') is-invalid @enderror">
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Front & Back Cover Images --}}
                        <div class="col-md-6 d-flex gap-2">
                            {{-- Front Cover --}}
                            <div class="text-center flex-fill">
                                <label class="form-label fw-bold">Front Cover</label>
                                <img id="front_cover_preview" src="{{ $defaultImage }}" alt="Front Cover Preview"
                                    class="img-thumbnail w-100 mb-2" style="max-height: 180px;">

                                <input type="file" name="front_cover" id="front_cover" accept="image/*"
                                    class="d-none" onchange="previewImage(this, '#front_cover_preview')">
                                <div class="d-grid gap-1">
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="document.getElementById('front_cover').click()">Select Image</button>
                                    <input type="text" id="front_cover_filename"
                                        class="form-control form-control-sm text-center mt-1"
                                        placeholder="No file selected" readonly>
                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                        onclick="openPreview('#front_cover_preview')">Preview</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="resetImage('#front_cover', '#front_cover_preview')">Remove</button>
                                </div>
                                <small class="text-muted d-block mt-1">Recommended size: 400x600px</small>
                            </div>

                            {{-- Back Cover --}}
                            <div class="text-center flex-fill">
                                <label class="form-label fw-bold">Back Cover</label>
                                <img id="back_cover_preview" src="{{ $defaultImage }}" alt="Back Cover Preview"
                                    class="img-thumbnail w-100 mb-2" style="max-height: 180px;">

                                <input type="file" name="back_cover" id="back_cover" accept="image/*" class="d-none"
                                    onchange="previewImage(this, '#back_cover_preview')">

                                <div class="d-grid gap-1">
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="document.getElementById('back_cover').click()">Select Image</button>
                                    <input type="text" id="back_cover_filename"
                                        class="form-control form-control-sm text-center mt-1"
                                        placeholder="No file selected" readonly>
                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                        onclick="openPreview('#back_cover_preview')">Preview</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="resetImage('#back_cover', '#back_cover_preview')">Remove</button>
                                </div>
                                <small class="text-muted d-block mt-1">Recommended size: 400x600px</small>
                            </div>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success px-4">Create Book</button>
                        <a href="{{ route('backend.books.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Image Preview Modal --}}
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Image Preview</h5>
                    <div class="d-flex gap-2 align-items-center">
                        <button type="button" class="btn btn-sm btn-outline-dark"
                            onclick="toggleFullscreen('#modalImage')">
                            <i class="bi bi-arrows-fullscreen"></i> Fullscreen
                        </button>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid rounded" style="max-height: 500px;">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Required JS libraries --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Book Form Scripts --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize date picker
            flatpickr("#published_date", {
                dateFormat: "d/m/Y"
            });

            const defaultImage = @json($defaultImage);

            document.querySelectorAll('input[type="file"]').forEach(input => {
                input.addEventListener('change', function() {
                    const previewId = this.id === 'front_cover' ? '#front_cover_preview' :
                        '#back_cover_preview';
                    previewImage(this, previewId);
                });
            });

            window.previewImage = function(input, previewId) {
                const preview = document.querySelector(previewId);
                const filenameInputId = input.id === 'front_cover' ?
                    '#front_cover_filename' :
                    '#back_cover_filename';

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(input.files[0]);

                    // Set filename
                    const fileName = input.files[0].name;
                    document.querySelector(filenameInputId).value = fileName;
                } else {
                    preview.src = defaultImage;
                    document.querySelector(filenameInputId).value = '';
                }
            }


            window.resetImage = function(inputId, previewId) {
                const input = document.querySelector(inputId);
                const preview = document.querySelector(previewId);
                input.value = '';
                preview.src = defaultImage;

                // Clear the filename field too
                const filenameFieldId = inputId === '#front_cover' ? '#front_cover_filename' :
                    '#back_cover_filename';
                document.querySelector(filenameFieldId).value = '';
            }

            window.openPreview = function(previewId) {
                const preview = document.querySelector(previewId);
                const modalImage = document.querySelector('#modalImage');
                modalImage.src = preview.src;
                new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
            }

            window.toggleFullscreen = function(selector) {
                const elem = document.querySelector(selector);
                if (!document.fullscreenElement) {
                    elem.requestFullscreen?.();
                } else {
                    document.exitFullscreen?.();
                }
            }
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (!form) return; // safeguard if no form found

            form.addEventListener('submit', async function(e) {
                const frontCoverInput = document.getElementById('front_cover');
                const backCoverInput = document.getElementById('back_cover');

                const options = {
                    maxSizeMB: 0.1, // Target ~100KB
                    maxWidthOrHeight: 600,
                    useWebWorker: true
                };

                const compressAndCheck = async (input) => {
                    if (!input || input.files.length === 0) return null;

                    const originalFile = input.files[0];
                    const compressedFile = await imageCompression(originalFile, {
                        ...options,
                        initialQuality: 0.25
                    });

                    if (compressedFile.size > 100 * 1024) {
                        throw new Error(
                            `${input.id.replace('_', ' ')} must be less than 100KB`);
                    }

                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(compressedFile);
                    input.files = dataTransfer.files;

                    return compressedFile;
                };

                try {
                    await compressAndCheck(frontCoverInput);
                    await compressAndCheck(backCoverInput);
                } catch (err) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Image Too Large',
                        text: err.message
                    });
                }
            });


        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
