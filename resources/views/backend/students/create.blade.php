@extends('layouts.admin')

@section('title', isset($student) ? 'Edit Student' : 'Add Student')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
    <style>
        .img-preview {
            max-width: 120px;
            border-radius: 0.5rem;
            margin-top: 0.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>{{ isset($student) ? '✏️ Edit Student' : '➕ Add Student' }}</h3>
            <a href="{{ route('backend.students.index') }}" class="btn btn-secondary">🔙 Back</a>
        </div>

        <form method="POST"
            action="{{ isset($student) ? route('backend.students.update', $student) : route('backend.students.store') }}"
            enctype="multipart/form-data" id="studentForm">
            @csrf
            @if (isset($student))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-3">
                    <div class="nav flex-column nav-pills" role="tablist">
                        <a class="nav-link active" data-bs-toggle="pill" href="#basic-info">👤 Basic Info</a>
                        <a class="nav-link" data-bs-toggle="pill" href="#academic-info">🏫 Academic</a>
                        <a class="nav-link" data-bs-toggle="pill" href="#photo-tab">📷 Photo</a>
                        <a class="nav-link" data-bs-toggle="pill" href="#login-tab">🔐 Login</a>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="tab-content p-4 bg-white shadow rounded">
                        @include('backend.students.partials.tab_basic')
                        @include('backend.students.partials.tab_academic')
                        @include('backend.students.partials.tab_photo')
                        @include('backend.students.partials.tab_login')
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">💾 Save Student</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection


@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-start" role="alert">
        <div>
            <strong>❌ Please fix the following errors:</strong>
            <ul class="mb-0 mt-1 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="btn-close ms-auto mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Flatpickr Init (if used elsewhere) --}}
    <script>
        flatpickr(".flatpickr", {
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
        });
    </script>

    {{-- Image Compression + Preview --}}
    <script>
        const photoInput = document.getElementById('photo');
        const previewImg = document.getElementById('photoPreview');

        photoInput?.addEventListener('change', async function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                const img = new Image();
                img.src = e.target.result;
                img.onload = function () {
                    const canvas = document.createElement('canvas');
                    const MAX_WIDTH = 300;
                    const scaleSize = MAX_WIDTH / img.width;
                    canvas.width = MAX_WIDTH;
                    canvas.height = img.height * scaleSize;

                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                    const compressedBase64 = canvas.toDataURL('image/jpeg', 0.7);
                    previewImg.src = compressedBase64;

                    fetch(compressedBase64).then(res => res.blob()).then(blob => {
                        const newFile = new File([blob], file.name, { type: 'image/jpeg' });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(newFile);
                        photoInput.files = dataTransfer.files;
                    });
                };
            };
            reader.readAsDataURL(file);
        });
    </script>

    {{-- Frontend Validation --}}
    <script>
        document.getElementById('studentForm').addEventListener('submit', function (e) {
            const firstName = document.getElementById('first_name').value.trim();
            const lastName = document.getElementById('last_name').value.trim();
            const enrollNo = document.getElementById('enrollment_no').value.trim();
            const libraryId = document.getElementById('student_library_id').value.trim();

            if (!firstName || !lastName || !enrollNo || !libraryId) {
                e.preventDefault();
                Swal.fire({
                    toast: true,
                    icon: 'error',
                    title: 'Please fill all required fields',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    </script>

    {{-- Laravel Flash & Validation Errors --}}
    <script>
        @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if(session('error'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 4000
            });
        @endif

        @if ($errors->has('email'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "Duplicate Email ID",
                text: "{{ $errors->first('email') }}",
                showConfirmButton: false,
                timer: 4000
            });
        @endif

        @if ($errors->has('student_library_id'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "Duplicate Library ID",
                text: "{{ $errors->first('student_library_id') }}",
                showConfirmButton: false,
                timer: 4000
            });
        @endif
    </script>

    
@endsection


