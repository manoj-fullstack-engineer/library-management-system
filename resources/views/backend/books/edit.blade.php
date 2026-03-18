@php
    $defaultImage = asset('images/default-book.png');
    $frontImage = $book->front_cover ? asset('storage/' . $book->front_cover) : $defaultImage;
    $backImage = $book->back_cover ? asset('storage/' . $book->back_cover) : $defaultImage;
@endphp

@extends('layouts.admin')

@section('title', 'Edit Book')

@section('content')
    <div class="container">
        <div class="card shadow rounded">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Edit Book</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('backend.books.update', $book->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        {{-- Title and Author --}}
                        <div class="col-md-6">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input id="title" type="text" name="title" value="{{ old('title', $book->title) }}"
                                required class="form-control @error('title') is-invalid @enderror">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="author" class="form-label">Author <span class="text-danger">*</span></label>
                            <input id="author" type="text" name="author" value="{{ old('author', $book->author) }}"
                                required class="form-control @error('author') is-invalid @enderror">
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ISBN and Publisher --}}
                        <div class="col-md-6">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input id="isbn" type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}"
                                class="form-control @error('isbn') is-invalid @enderror">
                            @error('isbn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="publisher" class="form-label">Publisher</label>
                            <input id="publisher" type="text" name="publisher"
                                value="{{ old('publisher', $book->publisher) }}"
                                class="form-control @error('publisher') is-invalid @enderror">
                            @error('publisher')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Published Date and Category --}}
                        <div class="col-md-6">
                            <label for="published_date" class="form-label">Published Date</label>
                            <input id="published_date" type="text" name="published_date"
                                value="{{ old('published_date', \Carbon\Carbon::parse($book->published_date)->format('d/m/Y')) }}"
                                class="form-control @error('published_date') is-invalid @enderror">
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
                                        {{ old('category_id', $book->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Language and Pages --}}
                        <div class="col-md-6">
                            <label for="language" class="form-label">Language</label>
                            <input id="language" type="text" name="language"
                                value="{{ old('language', $book->language) }}"
                                class="form-control @error('language') is-invalid @enderror">
                            @error('language')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="pages" class="form-label">Pages</label>
                            <input id="pages" type="number" name="pages" value="{{ old('pages', $book->pages) }}"
                                min="1" class="form-control @error('pages') is-invalid @enderror">
                            @error('pages')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="price" class="form-label">Price</label>
                            <input id="price" type="number" name="price"
                                value="{{ old('price', number_format($book->price ?? 0, 2, '.', '')) }}" min="0.00"
                                step="0.01" class="form-control @error('price') is-invalid @enderror">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        {{-- Status and Description --}}
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select id="status" name="status"
                                class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">Select Status</option>
                                @foreach (['available', 'issued', 'damaged', 'lost'] as $status)
                                    <option value="{{ $status }}"
                                        {{ old('status', $book->status) == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <input id="description" type="text" name="description"
                                value="{{ old('description', $book->description) }}"
                                class="form-control @error('description') is-invalid @enderror">
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Image Upload --}}
                        <div class="col-md-6 d-flex gap-2">
                            <div class="text-center flex-fill">
                                <label class="form-label fw-bold">Front Cover</label>
                                <img id="front_cover_preview" src="{{ $frontImage }}" alt="Front Cover"
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
                            </div>

                            <div class="text-center flex-fill">
                                <label class="form-label fw-bold">Back Cover</label>
                                <img id="back_cover_preview" src="{{ $backImage }}" alt="Back Cover"
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
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4">Update Book</button>
                        <a href="{{ route('backend.books.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="modalImagePreview" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript --}}
    <script>
        function previewImage(input, previewSelector) {
            const file = input.files[0];
            const preview = document.querySelector(previewSelector);
            const filenameInput = document.querySelector(previewSelector + '_filename');

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    if (filenameInput) filenameInput.value = file.name;
                };
                reader.readAsDataURL(file);
            }
        }

        function resetImage(inputSelector, previewSelector) {
            const input = document.querySelector(inputSelector);
            const preview = document.querySelector(previewSelector);
            const filenameInput = document.querySelector(previewSelector + '_filename');
            input.value = '';
            preview.src = '{{ $defaultImage }}';
            if (filenameInput) filenameInput.value = '';
        }

        function openPreview(selector) {
            const image = document.querySelector(selector);
            const modalImage = document.getElementById('modalImagePreview');
            modalImage.src = image.src;
            new bootstrap.Modal(document.getElementById('previewModal')).show();
        }
    </script>
@endsection
